<?php
require_once 'includes/db.php';

$name = $email = $password = $confirm_password = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Basic Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // Insert new user
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_pass);
            if ($stmt->execute()) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
                $name = $email = $password = $confirm_password = "";
            } else {
                $error = "Something went wrong. Try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register – MediQuick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="mb-4 text-center">Create an Account</h3>

            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif ($success): ?>
              <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST" action="">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <div class="mt-3 text-center">
              Already have an account? <a href="login.php">Login here</a>.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>