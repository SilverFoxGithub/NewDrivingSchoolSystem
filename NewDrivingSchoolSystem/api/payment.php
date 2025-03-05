<?php
include '../db/db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user_id, $amount, $status);

    if ($stmt->execute()) {
        echo "Payment recorded successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>