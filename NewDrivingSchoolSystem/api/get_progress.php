<?php
include '../db/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT course_name, completion_percentage FROM progress WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$progress = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $progress[] = $row;
    }
}

echo json_encode($progress);
$stmt->close();
$conn->close();
?>