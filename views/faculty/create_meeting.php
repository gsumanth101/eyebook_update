<?php

include('../../config/connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require 'zoom_integration.php';

// Load configuration
$config = require 'config.php';

$topic = $_POST['topic'];
$startTime = $_POST['start_time'];
$duration = $_POST['duration'];
$facultyId = $_SESSION['faculty_id'];

$zoom = new ZoomAPI($config['zoom']['client_id'], $config['zoom']['client_secret'], $config['zoom']['account_id'], $conn);
$meeting = $zoom->createMeeting($topic, $startTime, $duration, $facultyId);

header('Location: faculty_dashboard.php');
?>