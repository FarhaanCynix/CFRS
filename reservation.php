<?php
session_start();
require('config.php'); // Include your database connection code here

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect unauthenticated users to the login page
    exit();
}

// Initialize variables to store facility information
$facilityId = null;
$facilityName = null;

// Check if facility information is passed from the previous page
if (isset($_GET['facility_id']) && !empty($_GET['facility_id'])) {
    // Get the 'facility_id' from the URL and proceed with the SQL query
    $facilityId = $_GET['facility_id'];

    // Fetch facility name from the database based on the provided facility ID
    $fetchFacilityQuery = "SELECT name FROM facilities WHERE id = ?";
    $stmt = mysqli_prepare($con, $fetchFacilityQuery);
    mysqli_stmt_bind_param($stmt, "i", $facilityId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $facilityName = $row['name'];
    } else {
        echo "Facility not found.";
    }
} else {
    // Handle the case where 'facility_id' is not provided
    echo "Facility ID is missing or empty.";
}

if (isset($_POST['reserve'])) {
    // Capture user selections
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Insert reservation data into the database
    $insertQuery = "INSERT INTO reservations (user_id, facility_id, reservation_date, start_time, end_time, status, reservation_date_time) VALUES (?, ?, ?, ?, ?, 'Pending', NOW())";
    $stmt = mysqli_prepare($con, $insertQuery);
    
    // Bind the user ID and other values
    $userId = $_SESSION['user_id'];
    mysqli_stmt_bind_param($stmt, "iisss", $userId, $facilityId, $date, $startTime, $endTime);
    mysqli_stmt_execute($stmt);

    // Set session variable to store the reservation ID for later use in confirmation.php
    $_SESSION['reservation_id'] = mysqli_insert_id($con);

    // Redirect to confirmation page
    header('Location: confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Make a Reservation</title>
  <link rel="stylesheet" href="css/reservation.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
<div class="container">
  <h1>Make a Reservation</h1>

  <!-- Display facility information -->
  <p>Facility Name: <?php echo $facilityName; ?></p>

  <!-- Reservation form -->
  <form action="reservation.php?facility_id=<?php echo $facilityId; ?>" method="post">
    <input type="hidden" name="facility_id" value="<?php echo $facilityId; ?>">
    <input type="hidden" name="facility_name" value="<?php echo $facilityName; ?>">
    
    <label for="date">Date:</label>
    <input type="date" name="date" required>
    
    <label for="start_time">Start Time:</label>
    <input type="time" name="start_time" required>
    
    <label for="end_time">End Time:</label>
    <input type="time" name="end_time" required>
    
    <button type="submit" name="reserve">Reserve</button>
  </form>
</div>
</body>
</html>
