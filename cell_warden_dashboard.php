<?php
session_start();
require 'db_connection.php';

// Only allow access to CELL_WARDEN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'CELL_WARDEN') {
    header("Location: login.html");
    exit();
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['case_id'])) {
    $case_id = $_POST['case_id'];
    $new_status = $_POST['status'];
    $verified = isset($_POST['verified']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE cases SET status = ?, verified = ? WHERE id = ?");
    $stmt->bind_param("sii", $new_status, $verified, $case_id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cell Warden Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    select, input[type="checkbox"] {
      margin-top: 5px;
      margin-bottom: 10px;
    }
    button {
      padding: 8px 12px;
      background-color: #4CAF50;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Cell Warden Dashboard</h2>

    <table>
      <tr>
        <th>Case ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Verified</th>
        <th>Actions</th>
      </tr>

      <?php
      $result = $conn->query("SELECT * FROM cases ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td><?= $row['verified'] ? 'Yes' : 'No' ?></td>
          <td>
            <form method="POST" action="">
              <input type="hidden" name="case_id" value="<?= $row['id'] ?>">
              <select name="status" required>
                <option value="">Select Status</option>
                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
              </select>
              <label>
                <input type="checkbox" name="verified" <?= $row['verified'] ? 'checked' : '' ?>> Verified
              </label>
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
