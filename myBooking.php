<?php
session_start();
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/sidebars.css">
  <link rel="stylesheet" href="css/reserveListAdmin.css"> <!-- Link to your CSS file for styling -->
</head>

<body>
  <?php include_once 'sidebar.php'; ?>
  <div class="main-content">
    <div class="container">

      <form action="" method="post" class="option-form">
        <label for="selected_facility">Choose Facility:</label>
        <select name="selected_facility">
          <option value="0">None</option>
          <?php facilityIdOptionList($conn); ?>
        </select><br>

        <label for="status">Choose Status:</label>
        <select name="status">
          <option value="0">None</option>
          <option value="pending">Pending</option>
          <option value="rejected">Rejected</option>
          <option value="approved">Approved</option>
        </select><br>

        <label for="date">Date:</label>
        <input type="date" name="date">

        <button name="submit">Submit</button>
      </form>

      <form action="includes/deleteMyBooking.inc.php" method="post" class="form-action">
        <table>
          <thead>
            <tr>
              <th>Club</th>
              <th>Facility</th>
              <th>Purpose</th>
              <th>Date</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Bid</th>
              <th>Status</th>
              <th>Action</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Initials output OR If admin not choose 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
              // handlePostRequest($conn);
              handleFormSubmission($conn, ['organization', 'facility', 'purpose', 'date', 'start_time', 'end_time', 'bid', 'status', 'edit', 'checkbox'], 0, 1);
            } else {
              fetchAllBooking($conn, ['organization', 'facility', 'purpose', 'date', 'start_time', 'end_time', 'bid','status', 'edit', 'checkbox'], 0, 1);
            }
            ?>
          </tbody>
        </table>
        <button type="submit" name="delete">Delete</button>
      </form>
    </div>
  </div>
</body>


</html>