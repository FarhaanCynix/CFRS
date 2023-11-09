<?php
session_start();
require('config.php'); // Include your database connection code here

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php'); // Redirect unauthenticated users and non-admins to the login page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    // Check if the reservation exists and is in 'Pending' status
    $checkQuery = "SELECT * FROM reservations WHERE id = $reservationId AND status = 'Pending'";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Update the reservation status to 'Rejected'
        $rejectQuery = "UPDATE reservations SET status = 'Rejected' WHERE id = $reservationId";
        if (mysqli_query($con, $rejectQuery)) {
            // Redirect back to the admin dashboard
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "Failed to reject the reservation.";
        }
    } else {
        echo "Invalid reservation or it is already approved/rejected.";
    }
} else {
    echo "Invalid request.";
}
?>
