<?php
$servername = "localhost";
$username = "eyebook_user";
$password = "#**Admin123@**#";
$dbname = "eyebook";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "eyebook";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to close the connection
?>
