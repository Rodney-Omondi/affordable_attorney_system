<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'CELL_WARDEN') {
        echo "Unauthorized access.";
        exit();
    }

    $case_id = intval($_POST['case_id']);
    $new_status = trim($_POST['new_status']);

    $stmt = $conn->prepare("UPDATE cases SET status = ? WHERE case_id = ?");
    $stmt->bind_param("si", $new_status, $case_id);

    if ($stmt->execute()) {
        header("Location: cell_warden_dashboard.php");
        exit();
    } else {
        echo "Failed to update status.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
