<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all users
$result = $conn->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Users – MediQuick Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="text-center mb-4">All Registered Users</h3>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Registered On</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= $row['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No users found.</div>
  <?php endif; ?>

  <div class="mt-3 text-center">
    <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>