<?php
session_start();
echo "<h1>Welcome to the CELL WARDEN Dashboard</h1>";
echo "<p>Logged in as: " . $_SESSION['email'] . "</p>";
?>
