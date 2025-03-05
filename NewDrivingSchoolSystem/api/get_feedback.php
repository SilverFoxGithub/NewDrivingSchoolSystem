<?php
include '../db/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT instructor_id, feedback FROM feedback WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$feedback = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
}

echo json_encode($feedback);
$stmt->close();
$conn->close();
?>