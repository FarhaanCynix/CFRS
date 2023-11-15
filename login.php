<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="img/UPTM_Logo.png" alt="UPTM Facility Reservation System" class="avatar">
        </div>
        <h1>UPTM FACILITY RESERVATION SYSTEM</h1>
        <p>UNIVERSITI POLY-TECH MALAYSIA STUDENT</p>
        <form action="includes/login.inc.php" method="post"> <!-- Updated action to login_verification.php -->
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account yet? <a href="signup.php">Sign up here</a></p>
        <p>Forgot Password? <a href="forgot_password.php">Reset here</a></p>
    </div>

    <!-- Error Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <p id="error-message"></p>
            <button onclick="hidePopup()">Close</button>
        </div>
    </div>

    <script src="js/login.js"></script>

</body>

</html>