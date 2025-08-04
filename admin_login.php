<?php
session_start();
require_once 'db_connection.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    die("Both fields are required.");
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
        $_SESSION['email'] = $admin['email'];
        $_SESSION['role'] = 'ADMIN';
        $_SESSION['name'] = $admin['name'];
        $_SESSION['admin_id'] = $admin['admin_id'];
        header("Location: admin_dashboard.php");
        exit;
    }
}

echo "Invalid credentials.";
?>
