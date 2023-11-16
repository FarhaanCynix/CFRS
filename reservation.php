<?php
session_start();
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="css/sidebars.css">
  <link rel="stylesheet" href="css/reservation.css">
  <!-- <script src="https://kit.fontawesome.com/b99e675b6e.js"></script> -->
</head>

<body>
  <?php include_once 'sidebar.php'; ?>
  <div class="main-content">
    <h1>Make Reservation</h1>
    <div class="container">
      <?php
      if (isset($_GET['occupied'])) {
        echo '<p>Already Occupied</p>';
      }
      if (isset($_GET['book'])) {
        echo '<p>The slot is available. Now you can place your bid</p>';
      }
      if (isset($_GET['bid'])) {
        echo '<p>Booking successful. Wait for admin to approve it</p>';
      }
      ?>
      <form action="includes/reservation.inc.php" method="post">

        <label for="club">Club/Organization Name</label>
        <input type="text" name="club" required>

        <label for="purpose">Purpose of booking</label>
        <input type="text" name="purpose" required>

        <label for="select_facility">Choose Facility:</label>
        <select name="selected_facility" required>
          <?php facilityIdOptionList($conn); ?>
        </select>

        <label for="date">Date:</label>
        <input type="date" name="date" required>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required>

        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required>

        <button type="submit" name="reserve">Reserve</button>
      </form>
    </div>
  </div>

</body>

</html>