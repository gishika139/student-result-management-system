<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

$student = null;
$marks_list = [];
$total_obtained = 0;
$total_max = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ?");
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        $marks_query = $conn->prepare("SELECT * FROM marks WHERE student_id = ?");
        $marks_query->bind_param("i", $student['id']);
        $marks_query->execute();
        $marks_result = $marks_query->get_result();

        while ($row = $marks_result->fetch_assoc()) {
            $marks_list[] = $row;
            $total_obtained += $row['marks_obtained'];
            $total_max += $row['max_marks'];
        }
    }
}

$percentage = $total_max > 0 ? round(($total_obtained / $total_max) * 100, 2) : 0;

function getGrade($percentage) {
    if ($percentage >= 90) return "A+";
    elseif ($percentage >= 75) return "A";
    elseif ($percentage >= 60) return "B";
    elseif ($percentage >= 40) return "C";
    else return "Fail";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Result</title> 
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 50%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body> 
    <div class="container">
    <h2>View Student Result</h2>
    <form method="POST">
        Enter Roll No: <input type="text" name="roll_no" required>
        <input type="submit" value="Search">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$student) { ?>
        <p style="color:red;">No student found with this roll number.</p>
    <?php } ?>

    <?php if ($student) { ?>
        <h3>Name: <?php echo $student['name']; ?> | Class: <?php echo $student['class']; ?></h3>

        <table>
            <tr><th>Subject</th><th>Marks Obtained</th><th>Max Marks</th></tr>
            <?php foreach ($marks_list as $m) { ?>
                <tr>
                    <td><?php echo $m['subject']; ?></td>
                    <td><?php echo $m['marks_obtained']; ?></td>
                    <td><?php echo $m['max_marks']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <p><b>Total: <?php echo $total_obtained; ?> / <?php echo $total_max; ?></b></p>
        <p><b>Percentage: <?php echo $percentage; ?>%</b></p>
        <p><b>Grade: <?php echo getGrade($percentage); ?></b></p>
    <?php } ?>

    <br>
    <a href="add_student.php">Add Student</a> | <a href="add_marks.php">Add Marks</a> | <a href="dashboard.php">dashboard</a> | <a href="logout.php">logout</a>
</div> 
</body>
</html>