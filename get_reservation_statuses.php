<?php
require('config.php'); // Include your database connection code here

$reservationStatuses = array();

// Query the database to get the latest reservation statuses
$facilitiesQuery = "SELECT id, status FROM facilities";
$result = mysqli_query($con, $facilitiesQuery);
while ($row = mysqli_fetch_assoc($result)) {
  $reservationStatuses[$row['id']] = $row['status'];
}

// Return the reservation statuses as JSON
header('Content-Type: application/json');
echo json_encode($reservationStatuses);
