<?php
require 'db_connection.php';

function fetchUsers($conn, $table, $id_col, $first_name_col, $second_name_col, $email_col, $role_label) {
    $result = $conn->query("SELECT $id_col, $first_name_col, $second_name_col, $email_col FROM $table");

    if ($result->num_rows > 0) {
        echo "<h2>" . strtoupper($role_label) . " Accounts</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>First Name</th><th>Second Name</th><th>Email</th><th>Actions</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $id = $row[$id_col];
            $first = $row[$first_name_col];
            $second = $row[$second_name_col];
            $email = $row[$email_col];

            echo "<tr>
                    <td>$id</td>
                    <td>$first</td>
                    <td>$second</td>
                    <td>$email</td>
                    <td>
                        <a href='edit_user.php?role=$table&id=$id'>Edit</a> |
                        <a href='delete_user.php?role=$table&id=$id' onclick=\"return confirm('Are you sure you want to delete this $role_label?')\">Delete</a>
                    </td>
                  </tr>";
        }

        echo "</table><br><br>";
    } else {
        echo "<p>No $role_label accounts found.</p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage User Accounts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .role-section {
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
            width: 90%;
            max-width: 900px;
        }
        .role-section h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #2c3e50;
            color: white;
        }
        th, td {
            padding: 10px 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<h1>User Account Management</h1>

<?php
fetchUsers($conn, 'prisoner', 'user_id', 'first_name', 'second_name', 'email', 'USER');
fetchUsers($conn, 'cell_warden', 'user_id', 'first_name', 'second_name', 'email', 'CELL WARDEN');
fetchUsers($conn, 'pro_bono_lawyers', 'user_id', 'first_name', 'second_name', 'email', 'PRO BONO LAWYER');
fetchUsers($conn, 'admin', 'admin_id', 'name', 'name', 'email', 'ADMIN');


?>

</body>
</html>
