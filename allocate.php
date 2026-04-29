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

$classrooms = $conn->query("SELECT * FROM classrooms");
$courses = $conn->query("SELECT * FROM courses");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classroom_id = $_POST['classroom_id'];
    $course_id = $_POST['course_id'];
    $allocation_date = $_POST['allocation_date'];
    $time_slot = $_POST['time_slot'];

    $stmt = $conn->prepare("INSERT INTO allocations (classroom_id, course_id, allocation_date, time_slot) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $classroom_id, $course_id, $allocation_date, $time_slot);

    if ($stmt->execute()) {
        $success = "Allocation successful!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Allocate Classroom</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Allocate Classroom</h2>

    <form method="POST">
        <select name="classroom_id" required>
            <option value="">Select Classroom</option>
            <?php while($row = $classrooms->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['room_number']; ?> - <?php echo $row['building']; ?>
                </option>
            <?php } ?>
        </select>

        <select name="course_id" required>
            <option value="">Select Course</option>
            <?php while($row = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['course_code']; ?> - <?php echo $row['course_name']; ?>
                </option>
            <?php } ?>
        </select>

        <input type="date" name="allocation_date" required>
        <input type="text" name="time_slot" placeholder="Time Slot" required>

        <button type="submit">Allocate</button>
    </form>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>

