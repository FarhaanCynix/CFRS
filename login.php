<?php
session_start();

require('config.php'); // Include your database connection code here

if (isset($_SESSION['user_id'])) {
    // Redirect the user to the appropriate dashboard based on their role
    if ($_SESSION['is_admin'] == 1) {
        header('Location: admin_dashboard.php'); // Redirect admin to admin dashboard
    } else {
        header('Location: user_dashboard.php'); // Redirect regular user to user dashboard
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Universiti Poly-Tech Malaysia Student Facility Reservation System</title>
  <link rel="stylesheet" href="css/styles.css"> <!-- Link to your existing CSS file for styling -->
  <style>
  /* Add custom styles for the error popup */
  .popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    z-index: 1;
    width: 300px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .popup h2 {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
  }

  .popup p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
  }

  .popup button {
    background-color: #008cba;
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
    font-weight: bold;
    font-size: 16px;
  }

  .popup button:hover {
    background-color: #0069a3;
  }
</style>
</head>
<body>
<div class="container">
  <div class="logo-container">
    <img src="img/UPTM_Logo.png" alt="UPTM Facility Reservation System" class="avatar">
  </div>
  <h1>UPTM FACILITY RESERVATION SYSTEM</h1>
  <p>UNIVERSITI POLY-TECH MALAYSIA STUDENT</p>
  <form action="login_verification.php" method="post"> <!-- Updated action to login_verification.php -->
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
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

<script>
  // Function to show the popup
  function showPopup() {
    document.getElementById('popup').style.display = 'block';
  }

  // Function to hide the popup
  function hidePopup() {
    document.getElementById('popup').style.display = 'none';
  }

  // Check if an error message is present in the URL and display the popup if needed
  const urlParams = new URLSearchParams(window.location.search);
  const error = urlParams.get('error');
  if (error) {
    document.getElementById('error-message').textContent = error;
    showPopup();
  }
</script>
</body>
</html>
