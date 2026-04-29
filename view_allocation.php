<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT allocations.id, classrooms.room_number, classrooms.building,
        courses.course_code, courses.course_name,
        allocations.allocation_date, allocations.time_slot
        FROM allocations
        JOIN classrooms ON allocations.classroom_id = classrooms.id
        JOIN courses ON allocations.course_id = courses.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Allocation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Allocated Classrooms</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Building</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Date</th>
            <th>Time Slot</th>
        </tr>

        <?php
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['room_number']}</td>
                    <td>{$row['building']}</td>
                    <td>{$row['course_code']}</td>
                    <td>{$row['course_name']}</td>
                    <td>{$row['allocation_date']}</td>
                    <td>{$row['time_slot']}</td>
                  </tr>";
        }
        ?>
    </table>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
