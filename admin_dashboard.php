<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center mb-4">Welcome to Admin Dashboard</h2>

    <div class="d-grid gap-3 col-6 mx-auto">
      <a href="view_users.php" class="btn btn-primary">View All Users</a>
      <a href="view_all_appointments.php" class="btn btn-success">View All Appointments</a>
      <a href="admin_logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</body>
</html>