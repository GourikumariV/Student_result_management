<?php
$host = "localhost";
$user = "root";
$password = ""; // leave blank for default XAMPP
$database = "student_result";

$conn = new mysqli('localhost', 'root', '', 'student_result', 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
