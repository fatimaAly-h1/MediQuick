<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor = trim($_POST["doctor"]);
    $date = $_POST["date"];
    $time = $_POST["time"];
    $reason = trim($_POST["reason"]);

    if (empty($doctor) || empty($date) || empty($time) || empty($reason)) {
        $error = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_name, appointment_date, appointment_time, reason) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $doctor, $date, $time, $reason);
        if ($stmt->execute()) {
            $success = "Appointment booked successfully!";
        } else {
            $error = "Failed to book appointment.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <h3 class="text-center mb-4">Book an Appointment</h3>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Select Doctor</label>
        <select name="doctor" class="form-select" required>
          <option value="">-- Choose a doctor --</option>
          <option>Dr. Ayesha Khan - Cardiologist</option>
          <option>Dr. Ahmed Malik - Dentist</option>
          <option>Dr. Sana Tariq - Pediatrician</option>
          <option>Dr. Bilal Zafar - Dermatologist</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Appointment Date</label>
        <input type="date" name="date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Appointment Time</label>
        <input type="time" name="time" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Reason / Symptoms</label>
        <textarea name="reason" rows="3" class="form-control" placeholder="Briefly describe your issue..." required></textarea>
      </div>

      <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
    </form>

    <div class="mt-3 text-center">
      <a href="dashboard.php">← Back to Dashboard</a>
    </div>
  </div>

</body>
</html>