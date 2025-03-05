<?php
require '../db/db_connect.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");
?>