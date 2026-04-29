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
    $room_number = $_POST['room_number'];
    $building = $_POST['building'];
    $capacity = $_POST['capacity'];
    $room_type = $_POST['room_type'];

    $stmt = $conn->prepare("INSERT INTO classrooms (room_number, building, capacity, room_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $room_number, $building, $capacity, $room_type);

    if ($stmt->execute()) {
        $success = "Classroom added successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Classroom</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add Classroom</h2>

    <form method="POST">
        <input type="text" name="room_number" placeholder="Room Number" required>
        <input type="text" name="building" placeholder="Building" required>
        <input type="number" name="capacity" placeholder="Capacity" required>
        <input type="text" name="room_type" placeholder="Room Type" required>
        <button type="submit">Add Classroom</button>
    </form>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
