<?php
include_once 'functions.inc.php';
include_once 'db.inc.php';
if (isset($_POST['approve'])) {
    foreach ($_POST['booking'] as $bookingId) {
        approveBooking($conn, $bookingId);
    }
    header("Location: ../reserveListAdmin.php");
}

if (isset($_POST['pending'])) {
    foreach ($_POST['booking'] as $booking) {
        pendingBooking($conn, $booking);
    }
    header("Location: ../bookingListAdmin.php");
}
