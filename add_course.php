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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $teacher_name = $_POST['teacher_name'];
    $student_count = $_POST['student_count'];

    $stmt = $conn->prepare("INSERT INTO courses (course_code, course_name, teacher_name, student_count) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $course_code, $course_name, $teacher_name, $student_count);

    if ($stmt->execute()) {
        $success = "Course added successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add Course</h2>

    <form method="POST">
        <input type="text" name="course_code" placeholder="Course Code" required>
        <input type="text" name="course_name" placeholder="Course Name" required>
        <input type="text" name="teacher_name" placeholder="Teacher Name" required>
        <input type="number" name="student_count" placeholder="Student Count" required>
        <button type="submit">Add Course</button>
    </form>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>

