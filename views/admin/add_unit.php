<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Models\Database;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

require_once __DIR__ . '/../../aws_config.php';

$bucketName = AWS_BUCKET_NAME;
$region = AWS_REGION;
$accessKey = AWS_ACCESS_KEY_ID;
$secretKey = AWS_SECRET_ACCESS_KEY;

// Debugging: Log the values of the configuration variables
error_log('AWS_BUCKET_NAME: ' . $bucketName);
error_log('AWS_REGION: ' . $region);
error_log('AWS_ACCESS_KEY_ID: ' . $accessKey);
error_log('AWS_SECRET_ACCESS_KEY: ' . $secretKey);

if (!$bucketName || !$region || !$accessKey || !$secretKey) {
    throw new Exception('Missing AWS configuration in aws_config.php file');
}

$s3Client = new S3Client([
    'region' => $region,
    'version' => 'latest',
    'credentials' => [
        'key' => $accessKey,
        'secret' => $secretKey,
    ],
]);

$conn = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $unit_name = $_POST['unit_name'];
    $scorm_file = $_FILES['scorm_file'];

    if (!$unit_name || !$scorm_file) {
        echo json_encode(['message' => 'Unit name and SCORM package file are required']);
        exit;
    }

    // Fetch the course
    $sql = "SELECT * FROM courses WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        echo json_encode(['message' => 'Course not found']);
        exit;
    }

    // Validate SCORM package
    $zip = new ZipArchive();
    if ($zip->open($scorm_file['tmp_name']) === TRUE) {
        $scormVersion = 'Unknown';
        if ($zip->locateName('imsmanifest.xml') !== false) {
            $manifest = $zip->getFromName('imsmanifest.xml');
            if (strpos($manifest, 'ADL SCORM') !== false) {
                if (strpos($manifest, '2004') !== false) {
                    $scormVersion = 'SCORM 2004';
                } elseif (strpos($manifest, '1.2') !== false) {
                    $scormVersion = 'SCORM 1.2';
                } else {
                    $scormVersion = 'Other SCORM Version';
                }
            }
        }
        $zip->close();

        if ($scormVersion === 'Unknown') {
            echo json_encode(['message' => 'Invalid SCORM package']);
            exit;
        }
    } else {
        echo json_encode(['message' => 'Failed to open SCORM package']);
        exit;
    }

    // Extract and upload SCORM package to S3
    $extractPath = sys_get_temp_dir() . '/' . uniqid('scorm_', true);
    mkdir($extractPath);

    if ($zip->open($scorm_file['tmp_name']) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
    } else {
        echo json_encode(['message' => 'Failed to extract SCORM package']);
        exit;
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($extractPath));
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            continue;
        }

        $filePath = $file->getPathname();
        $key = "scorm_packages/{$course_id}/" . substr($filePath, strlen($extractPath) + 1);

        try {
            $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $key,
                'SourceFile' => $filePath,
                'ACL' => 'public-read', // Optional: Set the ACL to public-read if you want the file to be publicly accessible
            ]);
        } catch (AwsException $e) {
            echo json_encode(['message' => 'Error uploading file to S3: ' . $e->getMessage()]);
            exit;
        }
    }

    // Get the base URL of the uploaded SCORM package
    $baseUrl = $s3Client->getObjectUrl($bucketName, "scorm_packages/{$course_id}/");

    // Save the unit details to the database
    $sql = "INSERT INTO units (course_id, name, scorm_url, scorm_version) VALUES (:course_id, :name, :scorm_url, :scorm_version)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'course_id' => $course_id,
        'name' => $unit_name,
        'scorm_url' => $baseUrl,
        'scorm_version' => $scormVersion,
    ]);

    echo json_encode(['message' => 'Unit added successfully', 'scorm_url' => $baseUrl, 'scorm_version' => $scormVersion]);
}