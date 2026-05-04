<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT 
    allocations.id,
    classrooms.room_number,
    classrooms.building,
    classrooms.capacity,
    courses.course_code,
    courses.course_name,
    courses.student_count,
    allocations.allocation_date,
    allocations.time_slot
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
            <th>Capacity</th>    
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Students</th>     
            <th>Date</th>
            <th>Time Slot</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['room_number']}</td>
                        <td>{$row['building']}</td>
                        <td>{$row['capacity']}</td>
                        <td>{$row['course_code']}</td>
                        <td>{$row['course_name']}</td>
                        <td>{$row['student_count']}</td>
                        <td>{$row['allocation_date']}</td>
                        <td>{$row['time_slot']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No data found</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
