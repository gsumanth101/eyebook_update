<?php
include("sidebar.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $unit_name = $_POST['unit_name'];
    $scorm_file = $_FILES['scorm_file'];

    if (!$unit_name || !$scorm_file) {
        echo json_encode(['message' => 'Unit name and SCORM package file are required']);
        exit;
    }

    // Fetch the course
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    if (!$course) {
        echo json_encode(['message' => 'Course not found']);
        exit;
    }

    // Decode the existing content or initialize an empty array
    $course_content = json_decode($course['content'], true);
    if (!is_array($course_content)) {
        $course_content = [];
    }

    // Create a directory for the SCORM package
    $scorm_dir = 'uploads/' . time() . '-' . basename($scorm_file['name'], '.zip');
    mkdir($scorm_dir, 0777, true);

    // Move the uploaded file to the created directory
    $scorm_file_path = $scorm_dir . '/' . basename($scorm_file['name']);
    move_uploaded_file($scorm_file['tmp_name'], $scorm_file_path);

    // Unzip the SCORM package
    $zip = new ZipArchive;
    if ($zip->open($scorm_file_path) === TRUE) {
        $zip->extractTo($scorm_dir);
        $zip->close();
    } else {
        echo json_encode(['message' => 'Failed to unzip SCORM package']);
        exit;
    }

    // Verify that the index.html file exists
    $index_path = $scorm_dir . '/index.html';
    if (!file_exists($index_path)) {
        echo json_encode(['message' => 'index.html file not found']);
        exit;
    }

    // Add the new unit to the course content
    $new_unit = [
        'unitTitle' => $unit_name,
        'materials' => [['scormDir' => $scorm_dir, 'indexPath' => $index_path]]
    ];
    $course_content[] = $new_unit;

    // Update the course in the database
    $sql = "UPDATE courses SET content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $content_json = json_encode($course_content);
    $stmt->bind_param("si", $content_json, $course_id);
    $stmt->execute();

    echo json_encode(['message' => 'Unit added successfully with SCORM content', 'indexPath' => $index_path]);
}
?>