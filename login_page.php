<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Normalize email input
    $email = strtolower(trim($_POST['ename']));
    $password = trim($_POST['psw']);

    echo "<p>DEBUG Email received: '$email'</p>";

    // 2. Confirm database connection
    if (!$conn) {
        die(" Database connection failed: " . mysqli_connect_error());
    }

    // 3. Check current database
    $db_result = mysqli_query($conn, "SELECT DATABASE() AS db");
    $db_row = mysqli_fetch_assoc($db_result);
    echo "<p>Connected to DB: " . $db_row['db'] . "</p>";

    // 4. Build and run query
    $sql = "SELECT * FROM users WHERE LOWER(email) = '$email'";
    echo "<p>DEBUG SQL: $sql</p>";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die(" SQL Error: " . mysqli_error($conn));
    }

    $num = mysqli_num_rows($result);
    echo "<p>DEBUG Rows found: $num</p>";

    if ($num === 1) {
        $row = mysqli_fetch_assoc($result);

        // Check password (plain-text, not hashed)
        if ($row['password'] === $password) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            $role = strtoupper($row['user_type']);

            echo "<p> Logged in as: $role</p>";

            if ($role === "USER") {
                header("Location: user_dashboard.php"); exit();
            } elseif ($role === "ATTORNEY") {
                header("Location: attorney_dashboard.php"); exit();
            } elseif ($role === "ADMIN") {
                header("Location: admin_dashboard.php"); exit();
            } else {
                echo " Invalid role in DB.";
            }
        } else {
            echo " Incorrect password.";
        }
    } else {
        echo " User not found with that email.";
    }
}
?>
