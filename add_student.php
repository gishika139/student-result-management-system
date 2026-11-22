<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $class = $_POST['class'];

    $sql = "INSERT INTO students (roll_no, name, class) VALUES ('$roll_no', '$name', '$class')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Student added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>  
    <div class="container">
    <h2>Add New Student</h2>
    <form method="POST">
        Roll No: <input type="text" name="roll_no" required><br><br>
        Name: <input type="text" name="name" required><br><br>
        Class: <input type="text" name="class" required><br><br>
        <input type="submit" value="Add Student">
    </form>  
    <br>
<a href="dashboard.php">Dashboard</a> | <a href="add_marks.php">Add Marks</a> | <a href="view_result.php">View Result</a> | <a href="logout.php">Logout</a>
</div>
</body>
</html>