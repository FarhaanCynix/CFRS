<?php
session_start();
require('config.php'); // Include your database connection code here

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php'); // Redirect unauthenticated users and non-admins to the login page
    exit();
}

$reservationsQuery = "SELECT r.*, f.name AS facility_name, u.username AS username
                      FROM reservations r
                      JOIN facilities f ON r.facility_id = f.id
                      JOIN users u ON r.user_id = u.id";
$reservationsResult = mysqli_query($con, $reservationsQuery);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin_dashboard.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
<div class="container">
<div style="text-align: right; margin-right: 20px;">
    <a href="logout.php" style="color: red;">Logout</a>
  </div>
  <div class="logo-container">
    <img src="UPTM_Logo.png" alt="UPTM Campus Management System" class="avatar">
  </div>
  <h1>Welcome to the Admin Dashboard</h1>
  <p>Hello, Admin! You can manage reservations here.</p>

  <!-- Display reservations in a table -->
  <h2>Reservations</h2>
  <table>
    <thead>
      <tr>
        <th>Reservation ID</th>
        <th>Username</th>
        <th>Facility</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Status</th>
        <th>Action</th> <!-- Add a new column for the action -->
      </tr>
    </thead>
    <tbody>
      <?php
      while ($reservation = mysqli_fetch_assoc($reservationsResult)) {
        echo "<tr>";
        echo "<td>" . $reservation['id'] . "</td>";
        echo "<td>" . $reservation['username'] . "</td>";
        echo "<td>" . $reservation['facility_name'] . "</td>";
        echo "<td>" . $reservation['reservation_date'] . "</td>";
        echo "<td>" . $reservation['start_time'] . "</td>";
        echo "<td>" . $reservation['end_time'] . "</td>";
        echo "<td>" . $reservation['status'] . "</td>";

        // Add approve and reject buttons
        echo "<td>";
        if ($reservation['status'] == 'pending') {
          echo "<a href='approve_reservation.php?id={$reservation['id']}'>Approve</a> / ";
          echo "<a href='reject_reservation.php?id={$reservation['id']}'>Reject</a>";
        }
        echo "</td>";

        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
