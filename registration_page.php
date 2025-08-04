<?php
// Start the session
session_start();

// Include database connection
require_once 'db_connection.php';

// Collect and sanitize POST data
$first_name = trim($_POST['first_name'] ?? '');
$second_name = trim($_POST['second_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$passcode = $_POST['passcode'] ?? '';
$repeat_passcode = $_POST['passcode-repeat'] ?? '';
$role = $_POST['role'] ?? '';

// Check if all fields are filled
if (empty($first_name) || empty($second_name) || empty($email) || empty($passcode) || empty($repeat_passcode) || empty($role)) {
    die("All fields are required.");
}

// Check password match
if ($passcode !== $repeat_passcode) {
    die("Passwords do not match.");
}

// Assign table name based on role
switch ($role) {
    case 'PRISONER':
        $table = "prisoner";
        break;
  
    case 'PRO_BONO_LAWYER':
        $table = "pro_bono_lawyers";
        break;
    default:
        die("Invalid role selected.");
}

// Check if email already exists
$check_query = "SELECT user_id FROM $table WHERE email = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $check_stmt->close();
    die("Email already registered for this role. <a href='register.html'>Try again</a>.");
}
$check_stmt->close();

// Hash the password
$hashed_password = password_hash($passcode, PASSWORD_DEFAULT);

// Insert user data
$insert_query = "INSERT INTO $table (first_name, second_name, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ssss", $first_name, $second_name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "<h2>Registration successful!</h2>";
    echo "<p>You can now <a href='login.html'>login here</a>.</p>";
} else {
    echo " Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
