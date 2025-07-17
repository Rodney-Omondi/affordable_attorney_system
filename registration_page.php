
<?php
include("connection.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $second_name = $_POST['second_name'];
    $email = $_POST['email'];
    $password = $_POST['passcode'];
    $confirm_password = $_POST['passcode-repeat'];
    $role = strtoupper($_POST['role']); // Ensure it's in uppercase (USER, ATTORNEY, ADMIN)

    // Validate passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match. <a href='registration.html'>Go back</a>");
    }

    // Optional: Hash the password for security
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Choose the correct table and insert
    if ($role == "USER") {
        $sql = "INSERT INTO users (email, password, full_name, user_type) 
                VALUES ('$email', '$password', CONCAT('$first_name', ' ', '$second_name'), 'USER')";
    } elseif ($role == "PRO_BONO_LAWYER") {
        $sql = "INSERT INTO pro bono lawyer (email, password, full_name) 
                VALUES ('$email', '$password', CONCAT('$first_name', ' ', '$second_name'))";
    } elseif ($role == "CELL_WARDEN") {
        $sql = "INSERT INTO cell warden (email, password, full_name) 
                VALUES ('$email', '$password', CONCAT('$first_name', ' ', '$second_name'))";
    } else {
        die("Invalid role selected.");
    }

    // Run the query
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='login.html'>Click here to login</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

