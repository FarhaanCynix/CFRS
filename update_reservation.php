<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php'); // Redirect unauthorized users to the login page
    exit();
}

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $reservationId = $_POST['reservation_id'];
    $status = isset($_POST['approve']) ? "approved" : "pending";

    // Database connection
    require('config.php'); // Include your database connection code here

    // Update the reservation status in the database
    $updateQuery = "UPDATE reservations SET status = '$status' WHERE reservation_id = $reservationId";
    mysqli_query($con, $updateQuery);

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
}
