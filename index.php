<?php

require_once 'vendor/autoload.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
if (getenv('APP_ENV') === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}



use Bramus\Router\Router;

session_start();

$router = new Router();
$router->setNamespace('Controllers');

$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/profile', 'AdminController@userProfile');
$router->get('/admin/addUniversity', 'AdminController@addUniversity');
$router->post('/admin/addUniversity', 'AdminController@addUniversity');
$router->get('/admin/manage_university', 'AdminController@manageUniversity');
$router->post('/admin/updateUniversity', 'AdminController@updateUniversity');
$router->post('/admin/deleteUniversity', 'AdminController@deleteUniversity');
$router->get('/admin/updatePassword', 'AdminController@updatePassword');
$router->post('/admin/updatePassword', 'AdminController@updatePassword');
$router->get('/admin/uploadStudents', 'AdminController@uploadStudents');
$router->post('/admin/uploadStudents', 'AdminController@uploadStudents');
$router->post('/admin/deleteUniversity', 'AdminController@deleteUniversity');
$router->get('/admin/add_courses', 'AdminController@addCourse');
$router->post('/admin/add_courses', 'AdminController@addCourse');
$router->get('/admin/manage_courses', 'AdminController@manageCourse');
$router->get('/admin/view_course/(\d+)', 'AdminController@courseView');
$router->post('/admin/add_unit', 'AdminController@addUnit');
$router->post('/admin/assign_course', 'AdminController@assignCourse');
$router->get('/admin/manage_students', 'AdminController@manageStudents');
$router->get('/admin/view_student/(\d+)', 'AdminController@viewStudent');
$router->post('/admin/handleTodo', 'AdminController@handleTodo');
$router->get('/admin/viewStudentProfile/(\d+)', 'AdminController@viewStudentProfile');
$router->get('/admin/getUsageData', 'AdminController@getUsageData');
$router->get('/admin/download_usage_report', 'AdminController@downloadUsageReport');
$router->get('/admin/view_university/(\d+)', 'AdminController@viewUniversity');
$router->get('/admin/create_virtual_classroom', 'AdminController@createVirtualClassroom');
$router->post('/admin/create_virtual_classroom', 'AdminController@createVirtualClassroom');
$router->get('/admin/virtual_classroom', 'AdminController@virtualClassroom');
$router->get('/admin/edit_course/(\d+)', 'AdminController@editCourse');
$router->post('/admin/edit_course/(\d+)', 'AdminController@editCourse');
$router->get('/admin/delete_course/(\d+)', 'AdminController@deleteCourse');

$router->get('/admin/edit_university/(\d+)', 'AdminController@editUniversity');
$router->post('/admin/edit_university/(\d+)', 'AdminController@editUniversity');
$router->get('/admin/delete_university/(\d+)', 'AdminController@deleteUniversity');
$router->post('/admin/resetStudentPasswords', 'AdminController@resetStudentPasswords');
$router->get('/admin/edit_student/(\d+)', 'AdminController@editStudent');
$router->post('/admin/edit_student/(\d+)', 'AdminController@editStudent');
$router->get('/admin/delete_student/(\d+)', 'AdminController@deleteStudent');
$router->get('/admin/reset_student_password/(\d+)', 'AdminController@resetStudentPassword');


$router->get('/spoc', 'SpocController@dashboard');
$router->get('/spoc/dashboard', 'SpocController@dashboard');
$router->get('/spoc/updatePassword', 'SpocController@updatePassword');
$router->post('/spoc/updatePassword', 'SpocController@updatePassword');
$router->get('/spoc/profile', 'SpocController@userProfile');
$router->get('/spoc/addFaculty', 'SpocController@addFaculty');
$router->post('/spoc/addFaculty', 'SpocController@addFaculty');
$router->get('/spoc/manage_faculty', 'SpocController@manageFaculties');
$router->get('/spoc/view_faculty/(\d+)', 'SpocController@viewFaculty');
$router->post('/spoc/deleteFaculty', 'SpocController@deleteFaculty');

$router->get('/spoc/manage_students', 'SpocController@manageStudents');


$router->get('/faculty/dashboard', 'FacultyController@dashboard');
$router->get('/faculty/updatePassword', 'FacultyController@updatePassword');
$router->get('/faculty/profile', 'FacultyController@profile');
$router->post('/faculty/profile', 'FacultyController@profile');
$router->get('/faculty/my_courses', 'FacultyController@myCourses');
$router->get('/faculty/view_course/([a-zA-Z0-9]+)', 'FacultyController@viewCourse');
$router->get('/faculty/manage_students', 'FacultyController@manageStudents');



$router->get('/faculty/manage_assignments', 'FacultyController@manageAssignments');
$router->get('/faculty/create_assignment', 'FacultyController@createAssignment');
$router->post('/faculty/create_assignment', 'FacultyController@createAssignment');
$router->get('/faculty/view_assignment/(\d+)', 'FacultyController@viewAssignment');
$router->get('/faculty/grade_assignment/(\d+)/(\d+)', 'FacultyController@gradeAssignment');
$router->post('/faculty/grade_assignment/(\d+)/(\d+)', 'FacultyController@gradeAssignment');

$router->get('/faculty/download_report/(\d+)/(\w+)', 'FacultyController@downloadReport');

$router->post('/faculty/updatePassword', 'FacultyController@updatePassword');
$router->get('/faculty/discussion_forum/(\d+)', function(){
    require 'views/faculty/discussion_forum.php';
});
$router->post('/faculty/discussion_forum/(\d+)', function(){
    require 'views/faculty/discussion_forum.php';
});
$router->get('/faculty/create_assessment', function() {
    require 'views/faculty/faculty.php';
});
$router->post('/faculty/create_assessment', function() {
    require 'views/faculty/faculty.php';
});

// $router->get('/faculty/manage_assessments', 'FacultyController@manageAssessments');
$router->post('/faculty/generate_questions', function(){
    require 'views/faculty/api/generate_questions.php';
});

$router->get('/faculty/view_assessment_report/(\d+)', function($assessmentId) {
    require 'views/faculty/view_assessment_report.php';
});
$router->get('/faculty/download_assessment_report/(\d+)', function($assessmentId) {
    require 'views/faculty/download_assessment_report.php';
});

$router->get('/faculty/virtual_classroom', 'FacultyController@virtualClassroom');
$router->get('/faculty/download_attendance', 'FacultyController@downloadAttendance');

$router->post('/faculty/Update_profile','FacultyController@profile');

$router->get('/faculty/manage_students', 'FacultyController@manageStudents');


$router->get('/faculty/take_attendance', 'FacultyController@takeAttendance');
$router->post('/faculty/save_attendance', 'FacultyController@saveAttendance');

$router->get('/faculty/manage_assessments', function(){
    require 'views/faculty/manage_assessments.php';
});

$router->post('/faculty/view_course/upload_course_materials', function(){
    require 'views/faculty/upload_course_materials.php';
});

$router->get('/faculty/view_course_plan/(\w+)', 'FacultyController@viewCoursePlan');
$router->post('/faculty/view_course/upload_course_plan', function(){
    require 'views/faculty/upload_course_plan.php';
});

$router->get('/faculty/view_assessment_report/(\d+)', function($assessmentId) {
    require 'views/faculty/view_assessment_report.php';
});
$router->get('/faculty/download_assessment_report/(\d+)', function($assessmentId) {
    require 'views/faculty/download_assessment_report.php';
});



$router->get('/faculty/view_book/([a-zA-Z0-9]+)', 'FacultyController@viewBook');
$router->get('/faculty/view_course_plan/(\w+)', 'FacultyController@viewCoursePlan');
$router->get('/faculty/view_material/(\w+)', 'FacultyController@viewMaterial');
$router->get('/faculty/view_reports', 'FacultyController@viewReports');
$router->get('/faculty/download_report/(\d+)', 'FacultyController@downloadReport');



$router->get('/student/manage_assignments', 'StudentController@manageAssignments');
$router->get('/student/submit_assignment/(\d+)', 'StudentController@submitAssignment');
$router->post('/student/submit_assignment/(\d+)', 'StudentController@submitAssignment');
$router->get('/student/view_grades', 'StudentController@viewGrades');

$router->get('/student/dashboard', function(){
    require 'views/student/dashboard.php';
});
$router->get('/student/all_courses', function(){
    require 'views/student/all_courses.php';
});
$router->get('/student/updatePassword', function(){
    require 'views/student/updatePassword.php';
});
$router->post('/student/updatePassword', function(){
    require 'views/student/updatePassword.php';
});

$router->get('/student/profile', 'StudentController@profile');
$router->post('/student/profile', 'StudentController@profile');

$router->get('/student/discussion_forum/(\d+)', function(){
    require 'views/student/discussion_forum.php';
});
$router->post('/student/discussion_forum/(\d+)', function(){
    require 'views/student/discussion_forum.php';
});

$router->get('/student/my_courses', function(){
    require 'views/student/my_courses.php';
});

$router->get('/student/manage_assignments', 'StudentController@manageAssignments');
$router->get('/student/submit_assignment/(\d+)', 'StudentController@submitAssignment');
$router->post('/student/submit_assignment/(\d+)', 'StudentController@submitAssignment');
$router->get('/student/view_course_plan/(\w+)', 'StudentController@viewCoursePlan');
$router->get('/student/view_material/(\w+)', 'StudentController@viewMaterial');

$router->get('/student/submit_assignment/(\d+)', function($assignment_id){
    $_GET['assignment_id'] = $assignment_id;
    require 'views/student/assignment_submit.php';
});

$router->post('/student/submit_assignment/(\d+)', function($assignment_id){
    $_GET['assignment_id'] = $assignment_id;
    require 'views/student/assignment_submit.php';
});

$router->get('/student/assigments', function(){
    require 'views/student/assignment_submit.php';
});

// Faculty routes
$router->get('/faculty/manage_assignments', 'FacultyController@manageAssignments');

$router->get('/faculty/grade_assignment/(\d+)/(\d+)', 'FacultyController@gradeAssignment');
$router->post('/faculty/grade_assignment/(\d+)/(\d+)', 'FacultyController@gradeAssignment');

$router->get('/faculty/grade_assignment/(\d+)/(\d+)', function($assignment_id, $student_id){
    $_GET['assignment_id'] = $assignment_id;
    $_GET['student_id'] = $student_id;
    require 'views/faculty/grade_assignment.php';
});


$router->post('/faculty/grade_assignment/(\d+)/(\d+)', function($assignment_id, $student_id){
    $_GET['assignment_id'] = $assignment_id;
    $_GET['student_id'] = $student_id;
    require 'views/faculty/grade_assignment.php';
});


$router->post('/student/submit_assignment', 'StudentController@submitAssignment');

$router->post('/student/mark_as_completed', function() {
    require 'views/student/mark_as_completed.php';
});

$router->get('/student/view_course/([a-zA-Z0-9]+)', 'StudentController@viewCourse');

$router->get('/student/view_book/([a-zA-Z0-9]+)', 'StudentController@viewBook');

$router->get('/student/askguru', function(){
    require 'views/student/askguru.php';
});

$router->post('/student/askguru', function(){
    require 'views/student/askguru.php';
});

$router->get('/student/virtual_classroom', function(){
    require 'views/student/student_dashboard.php';
});

$router->get('/logout', 'AuthController@logout');
$router->get('/admin/logout', 'AuthController@logout');
$router->get('/spoc/logout', 'AuthController@logout');
$router->get('/faculty/logout', 'AuthController@logout');
$router->get('/student/logout', 'AuthController@logout');


$router->set404(function() {
    header('HTTP/1.0 404 Not Found');
    require 'views/404.html';
});

$router->run();
