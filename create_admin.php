<?php
require_once 'db_connection.php';

$email = "admin@justicec.org";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$name = "System Admin";

$stmt = $conn->prepare("INSERT INTO admin (email, password, name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $name);
$stmt->execute();

echo "Admin created.";
?>
