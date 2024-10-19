<?php
require __DIR__ . '/vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() {
    require __DIR__ . '/views/index.php';
});


$router->mount('/admin', function() use ($router) {
    $router->get('/login', function() {
        require __DIR__ . '/views/admin/login.php';
    });

    $router->post('/login', function() {
        require __DIR__ . '/views/admin/login.php';
    });

    $router->get('/dashboard', function() {
        require __DIR__ . '/views/admin/dashboard.php';
    });

    $router->get('/profile', function() {
        require __DIR__ . '/views/admin/profile.php';
    });

    $router->get('/logout', function() {
        require __DIR__ . '/views/admin/logout.php';
    });
    $router->get('/add_university', function(){
        require __DIR__ . '/views/admin/addUniversity.php';
    });

    $router->post('/add_university', function(){
        require __DIR__ . '/views/admin/addUniversity.php';
    });

    $router->get('/upload_students', function(){
        require __DIR__ . '/views/admin/uploadStudents.php';
    });
    $router->post('/upload_students', function(){
        require __DIR__ . '/views/admin/uploadStudents.php';
    });

    $router->get('/change_password', function(){
        require __DIR__ . '/views/admin/updatePassword.php';
    });
    $router->post('/change_password', function(){
        require __DIR__ . '/views/admin/updatePassword.php';
    });

    $router->get('/logout', function(){
        require __DIR__. '/views/admin/logout.php';
    });


});


$router->mount('/spoc', function() use ($router) {
    $router->get('/login', function() {
        require __DIR__ . '/views/spoc/login.php';
    });

    $router->post('/login', function() {
        require __DIR__ . '/views/spoc/login.php';
    });

    $router->get('/dashboard', function() {
        require __DIR__ . '/views/spoc/dashboard.php';
    });

    $router->get('/profile', function() {
        require __DIR__ . '/views/spoc/profile.php';
    });

    $router->get('/add_faculty', function(){
        require __DIR__ . '/views/spoc/addFaculty.php';
    });
    $router->post('/add_faculty', function(){
        require __DIR__ . '/views/spoc/addFaculty.php';
    });


    $router->get('/change_password', function(){
        require __DIR__ . '/views/spoc/updatePassword.php';
    });
    $router->post('/change_password', function(){
        require __DIR__ . '/views/spoc/updatePassword.php';
    });

    $router->get('/logout', function(){
        require __DIR__. '/views/spoc/logout.php';
    });


});

$router->mount('/faculty', function() use ($router) {
    $router->get('/login', function() {
        require __DIR__ . '/views/faculty/login.php';
    });

    $router->post('/login', function() {
        require __DIR__ . '/views/faculty/login.php';
    });

    $router->get('/dashboard', function() {
        require __DIR__ . '/views/faculty/dashboard.php';
    });

    $router->get('/profile', function() {
        require __DIR__ . '/views/faculty/profile.php';
    });

    $router->get('/add_faculty', function(){
        require __DIR__ . '/views/faculty/addFaculty.php';
    });
    $router->post('/add_faculty', function(){
        require __DIR__ . '/views/faculty/addFaculty.php';
    });


    $router->get('/change_password', function(){
        require __DIR__ . '/views/faculty/updatePassword.php';
    });
    $router->post('/change_password', function(){
        require __DIR__ . '/views/faculty/updatePassword.php';
    });

    $router->get('/logout', function(){
        require __DIR__. '/views/faculty/logout.php';
    });


});


$router->mount('/student', function() use ($router) {
    $router->get('/login', function() {
        require __DIR__ . '/views/student/login.php';
    });

    $router->post('/login', function() {
        require __DIR__ . '/views/student/login.php';
    });

    $router->get('/dashboard', function() {
        require __DIR__ . '/views/student/dashboard.php';
    });

    $router->get('/profile', function() {
        require __DIR__ . '/views/student/profile.php';
    });

    $router->get('/add_faculty', function(){
        require __DIR__ . '/views/student/addFaculty.php';
    });
    $router->post('/add_faculty', function(){
        require __DIR__ . '/views/student/addFaculty.php';
    });


    $router->get('/change_password', function(){
        require __DIR__ . '/views/faculty/updatePassword.php';
    });
    $router->post('/change_password', function(){
        require __DIR__ . '/views/student/updatePassword.php';
    });

    $router->get('/logout', function(){
        require __DIR__. '/views/student/logout.php';
    });


});


$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "<h1>404 Not Found</h1>";
    echo "<p>The page you are looking for does not exist.</p>";
});

// Run the router
$router->run();