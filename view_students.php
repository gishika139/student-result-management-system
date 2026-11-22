<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit(); }
include 'db_connect.php';
$result = $conn->query("SELECT * FROM students ORDER BY roll_no");
?>
<!DOCTYPE html>
<html>
<head><title>All Students</title><link rel="stylesheet" href="style.css"></head>
<body>
<h2>All Students</h2>
<table border="1" cellpadding="8">
<tr><th>Roll No</th><th>Name</th><th>Class</th><th>Action</th></tr>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td><?php echo htmlspecialchars($row['class']); ?></td>
    <td>
        <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a> |
        <a href="delete_student.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Student aur uske marks delete ho jayenge. Pakka?');">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>