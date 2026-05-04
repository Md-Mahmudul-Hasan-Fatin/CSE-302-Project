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
    $room_number = $_POST['room_number'];
    $building = $_POST['building'];
    $capacity = $_POST['capacity'];
    $room_type = $_POST['room_type'];

    $stmt = $conn->prepare("INSERT INTO classrooms (room_number, building, capacity, room_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $room_number, $building, $capacity, $room_type);
    $stmt->execute();
}

// Fetch
$result = $conn->query("SELECT * FROM classrooms");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Classrooms</title>
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

    <h2>All Classrooms</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Building</th>
            <th>Capacity</th>
            <th>Type</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['room_number']; ?></td>
            <td><?php echo $row['building']; ?></td>
            <td><?php echo $row['capacity']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td>
                <a href="edit_classroom.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_classroom.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php">Back</a>
</div>

</body>
</html>
