<?php
session_start();
require_once 'db_connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: login.html");
    exit();
}

// Fetch all cases
$sql = "SELECT id, user_id, title, prison_name, prison_location, category, description, status, verified, created_at, case_file, prisoner_id 
        FROM cases
        ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitor Case Flow</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background: #333;
            color: white;
            text-align: left;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Monitor Case Flow</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Title</th>
            <th>Prison Name</th>
            <th>Prison Location</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Verified</th>
            <th>Created At</th>
            <th>Case File</th>
            <th>Prisoner ID</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['prison_name']) ?></td>
                    <td><?= htmlspecialchars($row['prison_location']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= $row['verified'] ? 'Yes' : 'No' ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <?php if (!empty($row['case_file'])): ?>
                            <a href="uploads/<?= htmlspecialchars($row['case_file']) ?>" target="_blank">View File</a>
                        <?php else: ?>
                            No file
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['prisoner_id']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="12" style="text-align:center;">No cases found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
