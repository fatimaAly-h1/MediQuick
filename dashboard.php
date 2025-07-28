<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="alert alert-success text-center">
      👋 Welcome, <strong><?= htmlspecialchars($_SESSION["user_name"]) ?></strong>! <br>
      You have successfully logged in to MediQuick.
    </div>
    <div class="text-center my-2">
  <a href="my_appointments.php" class="btn btn-outline-primary">View My Appointments</a>
</div>

    <div class="text-center my-3">
  <a href="book_appointment.php" class="btn btn-success">Book a New Appointment</a>
</div>

    <div class="text-center">
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>


</body>
</html>