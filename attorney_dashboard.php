<?php
session_start();
echo "<h1>Welcome to the Attorney Dashboard</h1>";
echo "<p>Logged in as: " . $_SESSION['email'] . "</p>";
?>