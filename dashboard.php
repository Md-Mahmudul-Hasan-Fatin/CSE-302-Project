<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <h2>Dashboard</h2>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
    <p>Your Role: <?php echo $_SESSION['role']; ?></p>

    <div class="card-container">

        <?php if ($_SESSION['role'] == 'admin') { ?>
            <a class="card" href="add_classroom.php">Add Classroom</a>
            <a class="card" href="add_course.php">Add Course</a>
            <a class="card" href="allocate.php">Allocate Classroom</a>
        <?php } ?>

        <a class="card" href="view_allocation.php">View Allocation</a>
    </div>
</div>
</body>
</html>