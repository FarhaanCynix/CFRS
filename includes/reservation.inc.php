<?php
session_start();
include_once 'db.inc.php';
include_once 'functions.inc.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect unauthenticated users to the login page
    exit();
}

if (isset($_POST['reserve'])) {
    $userId = $_SESSION['user_id'];
    $club = $_POST['club'];
    $purpose = $_POST['purpose'];
    $facilityId = $_POST['selected_facility'];
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    if (isBookingOverlapWithApprovedBooking($conn, $facilityId, $date, $startTime, $endTime)) {
        header("Location: ../reservation.php?occupied=1");
        exit();
    }
    $_SESSION['isBid'] = 1;
    header("Location: ../bid.php?club=$club&purpose=$purpose&facility_id=$facilityId&date=$date&start_time=$startTime&end_time=$endTime");
    exit();
}
