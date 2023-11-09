<?php
require('config.php'); // Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $checkEmailQuery);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        // Generate a unique reset token (you can use a random string generator)
        $resetToken = bin2hex(random_bytes(16)); // Generate a random 32-character token

        // Store the reset token and its expiration time in the database
        $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
        $updateTokenQuery = "UPDATE users SET reset_token = '$resetToken', reset_token_expiration = '$tokenExpiration' WHERE id = " . $user['id'];
        if (mysqli_query($con, $updateTokenQuery)) {
            // Send an email to the user with a link to the reset_password.php page
            // The link should include the reset token, e.g., reset_password.php?token=your_reset_token

            // Redirect the user to a page that informs them to check their email for instructions
            header('Location: password_reset_instructions.php');
            exit();
        } else {
            echo "Token update failed. Please try again.";
        }
    } else {
        echo "Email not found in the database.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="css/forgot_password.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img src="img/UPTM_Logo.png" alt="Your Logo" class="avatar">
    </div>
    <h1>Forgot Password?</h1>
    <h2>Enter Your email</h2>
    <form action="forgot_password_verification.php" method="post">
      <input type="email" name="email" placeholder="Email">
      <button type="submit">Reset Password</button>
    </form>
    <a href="login.php">Back to Login</a>
  </div>
</body>
</html>


