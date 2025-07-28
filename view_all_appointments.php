<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

$query = "
SELECT a.id, u.name AS patient_name, a.doctor_name, a.appointment_date, a.appointment_time, a.reason, a.created_at
FROM appointments a
JOIN users u ON a.user_id = u.id
ORDER BY a.created_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Appointments – MediQuick Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="text-center mb-4">All Appointments (All Users)</h3>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Booked On</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['patient_name']) ?></td>
              <td><?= htmlspecialchars($row['doctor_name']) ?></td>
              <td><?= $row['appointment_date'] ?></td>
              <td><?= $row['appointment_time'] ?></td>
              <td><?= htmlspecialchars($row['reason']) ?></td>
              <td><?= $row['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No appointments found.</div>
  <?php endif; ?>

  <div class="mt-3 text-center">
    <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>