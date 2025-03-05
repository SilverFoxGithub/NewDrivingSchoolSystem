<?php
require '../db/db_connect.php';

$result = $conn->query("SELECT id, username, role FROM users");
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>