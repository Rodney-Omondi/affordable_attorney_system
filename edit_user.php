<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

if (isset($_GET['role']) && isset($_GET['id'])) {
    $role = $_GET['role'];
    $id = $_GET['id'];

    // Map role to table and columns
    $roleMap = [
        'prisoner' => ['table' => 'prisoner', 'id_col' => 'user_id'],
        'cell_warden' => ['table' => 'cell_warden', 'id_col' => 'user_id'],
        'pro_bono_lawyer' => ['table' => 'pro_bono_lawyer', 'id_col' => 'user_id'],
        'admin' => ['table' => 'admin', 'id_col' => 'admin_id']
    ];

    if (!isset($roleMap[$role])) {
        die("Invalid role.");
    }

    $table = $roleMap[$role]['table'];
    $id_col = $roleMap[$role]['id_col'];

    // Fetch current user details
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $id_col = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($role === 'admin') {
            $name = $_POST['name'];
            $email = $_POST['email'];

            $updateStmt = $conn->prepare("UPDATE $table SET name = ?, email = ? WHERE $id_col = ?");
            $updateStmt->bind_param("ssi", $name, $email, $id);
        } else {
            $first_name = $_POST['first_name'];
            $second_name = $_POST['second_name'];
            $email = $_POST['email'];

            $updateStmt = $conn->prepare("UPDATE $table SET first_name = ?, second_name = ?, email = ? WHERE $id_col = ?");
            $updateStmt->bind_param("sssi", $first_name, $second_name, $email, $id);
        }

        if ($updateStmt->execute()) {
            header("Location: view_users.php");
            exit();
        } else {
            echo "Update failed: " . $conn->error;
        }
    }
} else {
    die("Missing parameters.");
}
?>

<!-- Edit Form -->
<h2>Edit <?= strtoupper($role) ?> Account</h2>
<form method="POST">
    <?php if ($role === 'admin'): ?>
        <label>Name: <input type="text" name="name" value="<?= $user['name'] ?>" required></label><br>
    <?php else: ?>
        <label>First Name: <input type="text" name="first_name" value="<?= $user['first_name'] ?>" required></label><br>
        <label>Second Name: <input type="text" name="second_name" value="<?= $user['second_name'] ?>" required></label><br>
    <?php endif; ?>
    <label>Email: <input type="email" name="email" value="<?= $user['email'] ?>" required></label><br>
    <button type="submit">Update</button>
</form>
