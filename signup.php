<?php
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email address.";
    } else {
        // Check if the email is already registered
        if (isEmailAlreadyUsed($conn, $email)) {
            header("Location: signup.php?error=Email already in use");
            exit();
        }
        if (isUsernameAlreadyUsed($conn, $username)) {
            header("Location: signup.php?error=Username already in use");
            exit();
        }
        // Validate the password
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password) !== 1) {
            header("Location: signup.php?error=Password must be at least 8 characters and contain 1 uppercase, 1 lowercase, and 1 symbol.");
            exit();
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Prepare an SQL query to insert the user into the database
            $insertQuery = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";

            if (mysqli_query($conn, $insertQuery)) {
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
            <img src="img/UPTM_Logo.png" alt="UPTM Campus Management System" class="avatar">
        </div>
        <h1>UPTM FACILITY RESERVATION SYSTEM</h1>
        <p>UNIVERSITI POLY-TECH MALAYSIA STUDENT</p>
        <?php if (isset($_GET['error'])) {
            echo '<p class="error">' . $_GET['error'] . '</p>';
        }
        ?>
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