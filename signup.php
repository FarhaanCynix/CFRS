<?php
require('config.php'); // Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email address.";
    } else {
        // Check if the email is already registered
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $checkEmailQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "Email is already registered.";
        } else {
            // Validate the password
            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password) !== 1) {
                echo "Password must be at least 8 characters and contain 1 uppercase, 1 lowercase, and 1 symbol.";
            } else {
                // Hash the password securely
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Prepare an SQL query to insert the user into the database
                $insertQuery = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";

                if (mysqli_query($con, $insertQuery)) {
                    // Sign-up successful, redirect the user to the login page
                    header('Location: login.php');
                    exit(); // Ensure no further code execution after redirection
                } else {
                    // Handle the case where the sign-up failed
                    echo "Sign-up failed. Please try again.";
                }
            }
        }
    }
}
?>
<!-- Your HTML code for the sign-up form here -->

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up - College Facility Reservation</title>
  <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div class="container">
  <div class="logo-container">
    <img src="UPTM_Logo.png" alt="UPTM Campus Management System" class="avatar">
  </div>
  <h1>UPTM FACILITY RESERVATION SYSTEM</h1>
  <p>UNIVERSITI POLY-TECH MALAYSIA STUDENT</p>
  <form action="signup.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">SignUp</button>
    <p>Have an account? <a href="login.php">Login here</a></p>
  </form>
</div>
</body>
</html>
