<?php
session_start();
include_once 'functions.inc.php';
include_once 'db.inc.php';

$userId = $_SESSION['user_id'];
$bid = $_POST['bid'];
$tmp = $_POST['tmp'];
$club = $_POST['club'];
$purpose = $_POST['purpose'];
$facilityId = $_POST['facility_id'];
$date = $_POST['date'];
$startTime = $_POST['start_time'];
$endTime = $_POST['end_time'];

if (isset($_POST['bidBtn'])) {


    echo "$club<br>";
    echo "$purpose<br>";
    echo "$date<br>";
    echo "$startTime<br>";
    echo "$endTime<br>";
    echo "$facilityId<br>";
    echo "$tmp";
    echo "$bid";

    $sql = "INSERT INTO reservations (user_id, facility_id, reservation_date, start_time, end_time, status, reservation_date_time, organization, purpose, bid) 
        VALUES('$userId', '$facilityId', '$date', '$startTime', '$endTime', 'Pending', NOW(), '$club', '$purpose', '$bid');";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
    header("Location: ../reservation.php?bid=1");
    exit();
}
if (isset($_POST['noBidBtn'])) {
    echo 'asd';
    $sql = "INSERT INTO reservations (user_id, facility_id, reservation_date, start_time, end_time, status, reservation_date_time, organization, purpose, bid) 
        VALUES('$userId', '$facilityId', '$date', '$startTime', '$endTime', 'Pending', NOW(), '$club', '$purpose', '0');";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
    $_SESSION['isBid'] = 0;
    header("Location: ../reservation.php?bid=1");
    exit();
}

if(isset($_POST['editBid'])) {
    echo "asd";
}