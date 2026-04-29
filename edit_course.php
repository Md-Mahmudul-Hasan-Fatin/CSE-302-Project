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

$stmt = $conn->prepare("SELECT * FROM courses WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $teacher_name = $_POST['teacher_name'];
    $student_count = $_POST['student_count'];

    $stmt = $conn->prepare("UPDATE courses SET course_code=?, course_name=?, teacher_name=?, student_count=? WHERE id=?");
    $stmt->bind_param("sssii", $course_code, $course_name, $teacher_name, $student_count, $id);

    if ($stmt->execute()) {
        header("Location: add_course.php?updated=1");
        exit();
    }
}
?>

