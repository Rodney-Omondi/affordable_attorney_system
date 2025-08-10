<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }

    $prisoner_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $prison_name = $_POST['prison_name'];
    $prison_location = $_POST['prison_location'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $status = $_POST['status'];


    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO cases (prisoner_id, title, prison_name, prison_location, category, description, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $prisoner_id, $title, $prison_name, $prison_location, $category, $description, $status);

    if ($stmt->execute()) {
        header("Location: user_dashboard.php?success=1");
        exit();
    } else {
        echo "Error submitting case: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
