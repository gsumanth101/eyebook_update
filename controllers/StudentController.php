<?php
namespace Controllers;

use Models\Course;
use Models\Database;
use Models\Student;
use Models\Assignment;
use PDO;
use PDOException;

class StudentController {
    public function viewCourse($hashedId) {
        $conn = Database::getConnection();
        $course_id = base64_decode($hashedId);
        if (!is_numeric($course_id)) {
            die('Invalid course ID');
        }
        $course = Course::getById($conn, $course_id);

        // Fetch the student data
        if (!isset($_SESSION['email'])) {
            die('Email not set in session.');
        }
        $student = Student::getByEmail($conn, $_SESSION['email']);

        require 'views/student/view_course.php';
    }
    public function viewBook($hashedId) {
        $conn = Database::getConnection();
        $course_id = base64_decode($hashedId);
        if (!is_numeric($course_id)) {
            die('Invalid course ID');
        }
        $course = Course::getById($conn, $course_id);

        if (!$course || empty($course['course_book'])) {
            echo 'SCORM content not found.';
            exit;
        }

        // Assuming the first unit and first material for simplicity
        $unit = $course['course_book'][0];
        $material = $unit['materials'][0];
        $index_path = 'https://eyebook.phemesoft.com/' . $material['indexPath'];
        // $index_path = 'http://localhost/new/eyebook_update/' . $material['indexPath'];

        require 'views/student/book_view.php';
    }
    function getCoursesWithProgress($studentId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM courses WHERE status = 'ongoing'");
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT completed_books FROM students WHERE id = :student_id");
        $stmt->execute(['student_id' => $studentId]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        $completedBooks = !empty($student['completed_books']) ? json_decode($student['completed_books'], true) : [];

        foreach ($courses as &$course) {
            $courseId = $course['id'];
            $courseBooks = !empty($course['course_book']) ? json_decode($course['course_book'], true) : [];
            $totalBooks = is_array($courseBooks) ? count($courseBooks) : 0;
            $completedBooksCount = is_array($completedBooks[$courseId] ?? []) ? count($completedBooks[$courseId] ?? []) : 0;
            $course['progress'] = ($totalBooks > 0) ? ($completedBooksCount / $totalBooks) * 100 : 0;
        }

        usort($courses, function($a, $b) {
            return $a['progress'] <=> $b['progress'];
        });

        return $courses;
    }
    public function updatePassword() {
        $conn = Database::getConnection();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student = Student::getByEmail($conn, $_SESSION['email']);
            $new_password = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
    
            Student::updatePassword($conn, $student['id'], $new_password);
    
            $message = "Password updated successfully.";
            $message_type = "success";
        }
    
        require 'views/student/updatePassword.php';
    }

    public function manageAssignments() {
        $conn = Database::getConnection();
        $student = Student::getByEmail($conn, $_SESSION['email']);
        $assignments = Assignment::getAllByStudentId($conn, $student['id']);
        require 'views/student/manage_assignments.php';
    }

    public function submitAssignment($assignment_id) {
        $conn = Database::getConnection();
        $student = Student::getByEmail($conn, $_SESSION['email']);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $file = $_FILES["assignment_file"];
            $target_dir = "uploads/assignments/submissions/";
            $target_file = $target_dir . basename($file["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file type
            if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" && $fileType != "jpg") {
                echo "<div class='alert alert-danger'>Sorry, only PDF, DOC, DOCX, and JPG files are allowed.</div>";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<div class='alert alert-danger'>Sorry, file already exists.</div>";
                $uploadOk = 0;
            }

            // Check file size (limit to 5MB)
            if ($file["size"] > 5000000) {
                echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
            } else {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    $file_path = $target_file;
                    Student::submitAssignment($conn, $student['id'], $assignment_id, $file_path);
                    echo "<div class='alert alert-success'>The file ". htmlspecialchars(basename($file["name"])). " has been uploaded.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                }
            }
        }

        require 'views/student/assignment_submit.php';
    }
}
?>