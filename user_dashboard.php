<?php
session_start();
require('config.php'); // Include your database connection code here

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect unauthenticated users to the login page
    exit();
}

$facilitiesQuery = "SELECT * FROM facilities";
$result = mysqli_query($con, $facilitiesQuery);
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
<div class="container">
  <div style="text-align: right; margin-right: 20px;">
    <a href="logout.php" style="color: red;">Logout</a>
  </div>
  <div class="logo-container">
    <img src="UPTM_Logo.png" alt="UPTM Campus Management System" class="avatar">
  </div>
  <h1>Welcome to the UPTM Facility Reservation System</h1>
  <p>Hello! You can access user-specific features here.</p>

  <!-- Display available facilities in a table -->
  <h2>Available Facilities</h2>
  <table>
    <thead>
      <tr>
        <th>Facility ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Capacity</th>
        <th>Location</th>
        <th>Status</th>
        <th>Action</th> <!-- Add a new column for the action -->
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['capacity'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>";
        
        if ($row['status'] == 'reserved') {
          echo 'Reserved';
        } elseif ($row['status'] == 'available') {
          echo 'Available';
        } elseif ($row['status'] == 'occupied') {
          echo 'Occupied';
        } elseif ($row['status'] == 'unavailable') {
          echo 'Unavailable';
        }
        
        echo "</td>";

        // Add a conditional link to reservation.php
        if ($row['status'] == 'available') {
          echo "<td><a href='reservation.php?facility_id={$row['id']}&facility_name={$row['name']}'>Reserve</a></td>";
        } else {
          echo "<td>" . ($row['status'] == 'reserved' ? 'Reserved' : 'Occupied') . "</td>";
        }

        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
