<?php
include_once 'functions.inc.php';
include_once 'db.inc.php';

if (isset($_POST['edit'])) {
    $bookingId = $_GET['booking_id'];
    $row = getBookingDetailsById($conn, $bookingId);
    $facilityId = $row['facility_id'];

    if (!empty($_POST['club'])) {
        updateMyBooking($conn, $bookingId, 'organization', $_POST['club']);
    }

    if (!empty($_POST['purpose'])) {
        updateMyBooking($conn, $bookingId, 'purpose', $_POST['purpose']);
    }

    if (!empty($_POST['date'])) {
        $newDate = $_POST['date'];
        if (isBookingOverlapWithApprovedBooking($conn, $facilityId, $newDate, $row['start_time'], $row['end_time'])) {
            header("Location: ../editMyBooking.php?booking_id=$bookingId&occupied=1");
            exit();
        }
        updateMyBooking($conn, $bookingId, 'reservation_date', $_POST['date']);
    }

    if (!empty($_POST['start_time'])) {
        $newStartTime = $_POST['start_time'];
        if (isBookingOverlapWithApprovedBooking($conn, $facilityId, $row['reservation_date'], $newStartTime, $row['end_time'])) {
            header("Location: ../editMyBooking.php?booking_id=$bookingId&occupied=1");
            exit();
        }
        updateMyBooking($conn, $bookingId, 'start_time', $_POST['start_time']);
    }

    if (!empty($_POST['end_time'])) {
        $newEndTime = $_POST['end_time'];
        if (isBookingOverlapWithApprovedBooking($conn, $facilityId, $row['reservation_date'], $row['start_time'], $newEndTime)) {
            header("Location: ../editMyBooking.php?booking_id=$bookingId&occupied=1");
            exit();
        }
        updateMyBooking($conn, $bookingId, 'end_time', $_POST['end_time']);
    }

    if (!empty($_POST['bid'])) {
        updateMyBooking($conn, $bookingId, 'bid', $_POST['bid']);
    }

    // Redirect after all updates
    header("Location: ../editMyBooking.php?booking_id=$bookingId&book=1");
    exit();
}

if (isset($_POST['back'])) {
    header("Location: ../myBooking.php");
    exit();
}
