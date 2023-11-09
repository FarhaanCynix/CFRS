<?php
session_start();
require('config.php'); // Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // You can add your password reset logic here (e.g., generating a reset link, sending an email, etc.).

    // For this example, we'll just display a message to indicate that the password reset email has been sent.
    $message = "Password reset instructions have been sent to your email: $email";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password Verification</title>
  <link rel="stylesheet" href="css/forgot_password.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img src="img/UPTM_Logo.png" alt="Your Logo" class="avatar">
    </div>
    <h1>Forgot Password Verification</h1>
    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
    <a href="login.php">Back to Login</a>
  </div>
</body>
</html>
