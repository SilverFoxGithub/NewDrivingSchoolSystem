<?php
require '../db/db_connect.php'; // Correct

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = trim($_POST['role']);

    // Basic form validation
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        die("Please fill out all fields.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check password strength
    if (
        strlen($password) < 8 ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[a-zA-Z]/', $password) ||
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)
    ) {
        die("Password must be at least 8 characters long, with a mix of letters, numbers, and symbols.");
    }

    // Check if email already exists
    $check_email_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Email already registered. Please use a different email.");
    }
    $check_stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL query to insert new user
    $sql = "INSERT INTO users (full_name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $role);

    // Execute the query
    if ($stmt->execute()) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
