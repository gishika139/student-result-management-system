<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Get all students for dropdown
$students = $conn->query("SELECT id, roll_no, name FROM students");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks_obtained = $_POST['marks_obtained'];
    $max_marks = $_POST['max_marks'];

    $sql = "INSERT INTO marks (student_id, subject, marks_obtained, max_marks) VALUES ('$student_id', '$subject', '$marks_obtained', '$max_marks')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Marks added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Marks</title> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h2>Add Marks</h2>
    <form method="POST">
        Student: 
        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php while ($row = $students->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['roll_no'] . " - " . $row['name']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        Subject: <input type="text" name="subject" required><br><br>
        Marks Obtained: <input type="number" name="marks_obtained" required><br><br>
        Max Marks: <input type="number" name="max_marks" value="100" required><br><br>

        <input type="submit" value="Add Marks">
    </form>
    <br>
    <a href="dashboard.php">Dashboard</a> | <a href="add_student.php">Add Student</a> | <a href="view_result.php">View Result</a> | <a href="logout.php">Logout</a>
</div>
</body>
</html>