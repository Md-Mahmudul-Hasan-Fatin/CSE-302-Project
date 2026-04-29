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
    <title>Unauthorized</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Access Denied</h1>
    <p>You do not have permission to access this page.</p>
    <a href="dashboard.php">Go Back</a>
</div>
</body>
</html>