<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit(); }
include 'db_connect.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("UPDATE students SET roll_no=?, name=?, class=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['roll_no'], $_POST['name'], $_POST['class'], $id);
    if ($stmt->execute()) { header("Location: view_students.php"); exit(); }
    else { $msg = "Update fail hua (roll no duplicate ho sakta hai)."; }
}

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$s = $stmt->get_result()->fetch_assoc();
if (!$s) { die("Student nahi mila"); }
?>
<!DOCTYPE html>
<html>
<head><title>Edit Student</title><link rel="stylesheet" href="style.css"></head>
<body>
<h2>Edit Student</h2>
<p><?php echo $msg; ?></p>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
    <input type="text" name="roll_no" value="<?php echo htmlspecialchars($s['roll_no']); ?>" required><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($s['name']); ?>" required><br>
    <input type="text" name="class" value="<?php echo htmlspecialchars($s['class']); ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="view_students.php">Cancel</a>
</body>
</html>