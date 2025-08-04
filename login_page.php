<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["ename"] ?? '');
    $password = trim($_POST["psw"] ?? '');
    $role = trim($_POST["role"] ?? '');

    if (empty($email) || empty($password) || empty($role)) {
        echo "<script>alert('Email, password, and role are required.'); window.history.back();</script>";
        exit;
    }

    // Define roles and corresponding tables/dashboards
    $roleConfig = [
        'PRISONER' => ['table' => 'prisoner', 'redirect' => 'user_dashboard.php'],
        //'CELL_WARDEN' => ['table' => 'cell_warden', 'redirect' => 'cell_warden_dashboard.php'],
        'PRO_BONO_LAWYER' => ['table' => 'pro_bono_lawyers', 'redirect' => 'pro_bono_lawyer_dashboard.php'],
        'ADMIN' => ['table' => 'admin', 'redirect' => 'admin_dashboard.php'], 

    ];

    if (!isset($roleConfig[$role])) {
        echo "<script>alert('Invalid role selected.'); window.history.back();</script>";
        exit;
    }

    $table = $roleConfig[$role]['table'];
    $redirect = $roleConfig[$role]['redirect'];

    // Query user from the appropriate table
    $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
    if (!$stmt) {
        echo "<script>alert('Login error. Please try again later.'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role;
            $_SESSION['name'] = trim(($user['first_name'] ?? '') . ' ' . ($user['second_name'] ?? ''));
            $_SESSION['user_id'] = $user['user_id'] ?? $user['id'] ?? $user['prisoner_id'] ?? null;

            $stmt->close();
            $conn->close();

            header("Location: $redirect");
            exit;
        } else {
            $stmt->close();
            $conn->close();
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
            exit;
        }
    } else {
        $stmt->close();
        $conn->close();
        echo "<script>alert('No account found for this email and role.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    exit;
}
?>
