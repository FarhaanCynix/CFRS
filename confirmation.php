<?php
session_start();
require('config.php'); // Include your database connection code here

// Check if the reservation ID is present in the session
if (isset($_SESSION['reservation_id'])) {
    // Get the reservation ID from the session
    $reservationId = $_SESSION['reservation_id'];

    // Query to retrieve reservation details from the database
    $query = "SELECT r.*, f.name AS facility_name FROM reservations r
              JOIN facilities f ON r.facility_id = f.id
              WHERE r.id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $reservationId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $facilityName = $row['facility_name'];
        $date = $row['reservation_date'];
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reservation Confirmation</title>
  <link rel="stylesheet" href="css/confirmation.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
<div class="container">
  <h1>Reservation Confirmation</h1>
  <p>Your reservation is succesfull. Waiting for admin approval.</p>

  <!-- Display reservation details from the database -->
  <h2>Reservation Details</h2>
  <ul>
    <li><strong>Facility Name:</strong> <?php echo $facilityName; ?></li>
    <li><strong>Date:</strong> <?php echo $date; ?></li>
    <li><strong>Start Time:</strong> <?php echo $startTime; ?></li>
    <li><strong>End Time:</strong> <?php echo $endTime; ?></li>
  </ul>

  <div class="btn-container">
  <a href="user_dashboard.php" class="btn">Make Another Reservation</a>
</div>
</body>
</html>

