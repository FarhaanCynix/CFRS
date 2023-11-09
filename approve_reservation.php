<?php
session_start();
require('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];
    
    // Check if the reservation exists and is pending
    $checkReservationQuery = "SELECT * FROM reservations WHERE id = $reservationId AND status = 'Pending'";
    $checkReservationResult = mysqli_query($con, $checkReservationQuery);

    if ($checkReservationResult && mysqli_num_rows($checkReservationResult) > 0) {
        // Retrieve the facility ID associated with the reservation
        $reservationData = mysqli_fetch_assoc($checkReservationResult);
        $facilityId = $reservationData['facility_id'];

        // Update the status of the reservation to "Approved"
        $updateReservationQuery = "UPDATE reservations SET status = 'Approved' WHERE id = $reservationId";
        $updateReservationResult = mysqli_query($con, $updateReservationQuery);

        if ($updateReservationResult) {
            // Update the status of the facility to "Reserved"
            $updateFacilityQuery = "UPDATE facilities SET status = 'Reserved' WHERE id = $facilityId";
            $updateFacilityResult = mysqli_query($con, $updateFacilityQuery);

            if ($updateFacilityResult) {
                header('Location: admin_dashboard.php');
                exit();
            } else {
                echo "Failed to update facility status.";
            }
        } else {
            echo "Failed to update reservation status.";
        }
    } else {
        echo "Reservation not found or not pending.";
    }
} else {
    echo "Invalid request.";
}
?>
