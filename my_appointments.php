<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Get appointments for this user
$stmt = $conn->prepare("SELECT doctor_name, appointment_date, appointment_time, reason, created_at FROM appointments WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Appointments – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <h3 class="text-center mb-4">My Booked Appointments</h3>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
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
      <div class="alert alert-info text-center">No appointments booked yet.</div>
    <?php endif; ?>

    <div class="mt-3 text-center">
      <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
  </div>

</body>
</html>