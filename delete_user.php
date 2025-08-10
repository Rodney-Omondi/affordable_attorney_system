<?php
include 'db_connection.php';

if (isset($_GET['role']) && isset($_GET['id'])) {
    $role = $_GET['role'];
    $id = $_GET['id'];

    // Map role to table name and ID column
    $tableMap = [
        'prisoner' => ['table' => 'prisoner', 'id_col' => 'user_id'],
        'cell_warden' => ['table' => 'cell_warden', 'id_col' => 'user_id'],
        'pro_bono_lawyer' => ['table' => 'pro_bono_lawyer', 'id_col' => 'user_id'],
        'admin' => ['table' => 'admin', 'id_col' => 'admin_id']
    ];

    if (array_key_exists($role, $tableMap)) {
        $table = $tableMap[$role]['table'];
        $id_col = $tableMap[$role]['id_col'];

        // Prepare and execute deletion query
        $stmt = $conn->prepare("DELETE FROM $table WHERE $id_col = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: view_users.php");
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Invalid role type.";
    }
} else {
    echo "Missing parameters.";
}
?>
