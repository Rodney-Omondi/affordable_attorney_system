<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Cell Warden</title>
</head>
<body>
  <h2>Create Cell Warden Account</h2>
  <form action="save_cell_warden.php" method="POST">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="second_name" placeholder="Second Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create</button>
  </form>
</body>
</html>
