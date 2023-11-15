<?php
session_start();
include_once 'includes/db.inc.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php'); // Redirect unauthenticated users to the login page
  exit();
}

$sql = "SELECT * FROM facilities;";
$result = $conn->query($sql)
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
          <th>Schedule</th>
          <th>Action</th> <!-- Add a new column for the action -->
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['description'] . "</td>";
          echo "<td>" . $row['capacity'] . "</td>";
          echo "<td>" . $row['location'] . "</td>";
          echo '<td><a href="schedule.php?facility_id=' . $row['id'] . '&facility_name=' . $row['name'] . '">Schedule</a></td>';

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