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
  <link rel="stylesheet" href="css/schedule.css"> <!-- Link to your CSS file for styling -->
</head>

<body>
  <?php include_once 'sidebar.php'; ?>
  <div class="main-content">
    <div class="container">
      <h1>Schedule</h1>
      <div class="form-filter">
        <form action="" method="post">
          <table class="filter">
            <tr>
              <td><label for="selected_facility">Choose Facility:</label></td>
              <td>
                <select name="selected_facility">
                  <option value="0">None</option>
                  <?php facilityIdOptionList($conn); ?>
                </select><br>
              </td>
            </tr>
            <tr>
              <td><label for="date">Date:</label></td>
              <td><input type="date" name="date"></td>
            </tr>
          </table>
          <button name="submit">Submit</button>
        </form>
      </div>

      <table class="list">
        <thead>
          <tr>
            <th>Organizer</th>
            <th>Club</th>
            <th>Facility</th>
            <th>Purpose</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Initials output OR If admin not choose 
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            handleFormSubmission($conn, ['username', 'organization', 'facility', 'purpose', 'date', 'start_time', 'end_time'], 1, 0);
          } else {
            fetchAllBooking($conn, ['username', 'organization', 'facility', 'purpose', 'date', 'start_time', 'end_time'], 1, 0);
          }
          ?>
        </tbody>
      </table>
      </form>
    </div>
  </div>
</body>


</html>