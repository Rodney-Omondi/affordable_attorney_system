<?php
session_start();

if ($_SESSION['role'] !== 'ADMIN') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - JusticeC</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        h1 { color: #333; }
        a.button {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            margin: 10px 5px;
            border-radius: 5px;
        }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <p>What would you like to do?</p>

    <a class="button" href="manage_users.php">Manage User Accounts</a>
    <a class="button" href="monitor_cases.php">Monitor Case Flow</a>
    <a class="button" href="create_cell_warden.php">Create Cell Warden Account</a>
    <a class="button" href="logout.php">Logout</a>
</body>
</html>
