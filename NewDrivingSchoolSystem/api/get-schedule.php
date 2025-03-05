<?php
include '../db/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT course_name, schedule_date FROM schedules WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$schedule = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schedule[] = $row;
    }
}

echo json_encode($schedule);
$stmt->close();
$conn->close();
?>