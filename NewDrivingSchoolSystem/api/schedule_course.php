<?php
include '../db/db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $course_name = $_POST['course_name'];
    $schedule_date = $_POST['schedule_date'];

    $stmt = $conn->prepare("INSERT INTO schedules (user_id, course_name, schedule_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $course_name, $schedule_date);

    if ($stmt->execute()) {
        echo "Course scheduled successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>