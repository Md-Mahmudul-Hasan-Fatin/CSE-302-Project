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

// Insert
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $teacher_name = $_POST['teacher_name'];
    $student_count = $_POST['student_count'];

    $stmt = $conn->prepare("INSERT INTO courses (course_code, course_name, teacher_name, student_count) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $course_code, $course_name, $teacher_name, $student_count);
    $stmt->execute();
}

// Fetch
$result = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
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

    <h2>All Courses</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Teacher</th>
            <th>Students</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['course_code']; ?></td>
            <td><?php echo $row['course_name']; ?></td>
            <td><?php echo $row['teacher_name']; ?></td>
            <td><?php echo $row['student_count']; ?></td>
            <td>
                <a href="edit_course.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_course.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php">Back</a>
</div>

</body>
</html>
