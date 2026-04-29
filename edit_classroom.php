<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: unauthorized.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM classrooms WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_number = $_POST['room_number'];
    $building = $_POST['building'];
    $capacity = $_POST['capacity'];
    $room_type = $_POST['room_type'];

    $stmt = $conn->prepare("UPDATE classrooms SET room_number=?, building=?, capacity=?, room_type=? WHERE id=?");
    $stmt->bind_param("ssisi", $room_number, $building, $capacity, $room_type, $id);

    if ($stmt->execute()) {
        header("Location: add_classroom.php?updated=1");
        exit();
    }
}
?>
