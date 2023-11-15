<?php
include_once 'functions.inc.php';
include_once 'db.inc.php';
if(isset($_POST['delete'])) {
    foreach($_POST['booking'] as $bookingId) {
        deleteBookingById($conn, $bookingId);
    }
    header("Location: ../myBooking.php");
}