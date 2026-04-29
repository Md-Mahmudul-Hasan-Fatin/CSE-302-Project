<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "smart_classroom_system_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>