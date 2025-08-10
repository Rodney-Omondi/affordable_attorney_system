<?php
session_start();
echo "<h1>Welcome, Pro Bono Lawyer!</h1>";
echo "<p>You are logged in as: " . htmlspecialchars($_SESSION['email'] ?? 'Unknown') . "</p>";
?>
