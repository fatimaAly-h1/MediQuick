<?php
session_start();

// Hardcoded admin credentials
$admin_email = "admin@mediquick.com";
$admin_password = "admin123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="text-center mb-4">Admin Login</h3>

            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Admin Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-dark w-100">Login as Admin</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>