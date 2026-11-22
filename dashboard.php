<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
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
<div class="container">
    <h2>Welcome, Admin!</h2>
    <p><a href="add_student.php">Add Student</a></p>
    <p><a href="add_marks.php">Add Marks</a></p>
    <p><a href="view_result.php">View Result</a></p>
    <p><a href="logout.php">Logout</a></p> 
    <a href="view_students.php">View / Edit / Delete Students</a>
</div>
</body>
</html>