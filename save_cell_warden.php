<?php
require_once 'db_connection.php';

$first = $_POST['first_name'];
$second = $_POST['second_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO cell_warden (first_name, second_name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $first, $second, $email, $password);

if ($stmt->execute()) {
    echo "<script>alert('Cell warden created successfully'); window.location.href='admin_dashboard.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}
