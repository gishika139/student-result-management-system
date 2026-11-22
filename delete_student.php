<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit(); }
include 'db_connect.php';

$id = (int)($_GET['id'] ?? 0);

// pehle marks delete (foreign key ki wajah se), fir student
$stmt = $conn->prepare("DELETE FROM marks WHERE student_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: view_students.php");
exit();