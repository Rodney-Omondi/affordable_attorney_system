<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'PRISONER') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Prisoner Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
    }
    .success {
      color: green;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Submit a Legal Case</h2>

    <?php if (isset($_GET['success'])): ?>
      <p class="success">Case submitted successfully!</p>
    <?php endif; ?>

    <form action="submit_case.php" method="POST" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Case Title" required>
  <input type="text" name="prison_name" placeholder="Prison Name" required>
  <input type="text" name="prison_location" placeholder="Prison Location" required>
  <select name="category" required>
    <option value="">Select Category</option>
    <option value="Domestic Violence">Domestic Violence</option>
    <option value="Wrongful Arrest">Wrongful Arrest</option>
    <option value="Property Dispute">Property Dispute</option>
    <option value="Other">Other</option>
  </select>
  <textarea name="description" placeholder="Describe the issue..." rows="5" required></textarea>

  <!-- New File Upload Field -->
  <label>Upload Case File:</label>
  <input type="file" name="case_file" accept=".pdf,.doc,.docx,.jpg,.png">

  <input type="hidden" name="status" value="Submitted">
  <select name="status" required>
  <option value="">Select Case Status</option>
  <option value="Pending">Pending</option>
  <option value="Submitted">Submitted</option>
</select>

  
  <button type="submit">Submit Case</button>
</form>

  </div>
</body>
</html>
