<?php
require '../db/db_connect.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
$conn->query($sql);

header("Location: ../manage_users.html");
?>