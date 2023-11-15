<?php
function facilityIdOptionList($conn)
{
    $rows = getAllFacilitiesDetails($conn);

    foreach ($rows as $row) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}

function getUsernameFromUserId($conn, $id)
{
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();
    return $row['username'];
}

function getFacilityNameById($conn, $id)
{
    $sql = "SELECT * FROM facilities WHERE id = '$id';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
    $row = $result->fetch_assoc();
    return $row['name'];
}

function approveBooking($conn, $bookingId)
{
    $booking = getBookingDetailsById($conn, $bookingId);
    if (isBookingOverlapWithApprovedBooking($conn, $booking['facility_id'], $booking['reservation_date'], $booking['start_time'], $booking['end_time'])) {
        header("Location: ../bookingListAdmin.php");
        exit();
    }
    $sql = "UPDATE reservations SET status = 'approved' WHERE id = '$bookingId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }


    // reject other overlapping booking
    $overlappingBookingIds = getPendingOverlappingBookingIds($conn, $booking['facility_id'], $booking['reservation_date'], $booking['start_time'], $booking['end_time']);

    foreach ($overlappingBookingIds as $id) {
        rejectBooking($conn, $id);
    }

    header("Location: ../bookingListAdmin.php");
    exit();
}

function pendingBooking($conn, $bookingId)
{
    $sql = "UPDATE reservations SET status = 'pending' WHERE id = '$bookingId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
}
function rejectBooking($conn, $bookingId)
{
    $sql = "UPDATE reservations SET status = 'rejected' WHERE id = '$bookingId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
}

function getBookingDetailsById($conn, $bookingId)
{
    $sql = "SELECT * FROM reservations WHERE id = '$bookingId'";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();
    return $row;
}

function getAllFacilitiesDetails($conn)
{
    $sql = "SELECT * FROM facilities";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function getPendingOverlappingBookingIds($conn, $facilityId, $date, $startTime, $endTime)
{
    $sql = "SELECT id FROM reservations 
            WHERE facility_id = '$facilityId' AND reservation_date = '$date' AND status = 'pending'
            AND (
                ('$startTime' >= start_time AND '$startTime' < end_time) OR
                ('$endTime' > start_time AND '$endTime' <= end_time) OR
                ('$startTime' <= start_time AND '$endTime' >= end_time)
            )";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error getting pending overlapping booking IDs: " . $conn->error);
    }

    $pendingOverlappingIds = [];
    while ($row = $result->fetch_assoc()) {
        $pendingOverlappingIds[] = $row['id'];
    }

    return $pendingOverlappingIds;
}

function isBookingOverlapWithApprovedBooking($conn, $facilityId, $date, $startTime, $endTime)
{
    $sql = "SELECT COUNT(*) as count 
        FROM reservations 
        WHERE 
        status = 'approved' AND
        facility_id = '$facilityId' AND
        reservation_date = '$date'
          AND (
            ('$startTime' >= start_time AND '$startTime' < end_time) OR
            ('$endTime' > start_time AND '$endTime' <= end_time) OR
            ('$startTime' <= start_time AND '$endTime' >= end_time)
          );";

    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        return 1;
    }
    return 0;
}

function handleFormSubmission($conn, $displayOptions = [], $isApprove, $isUser)
{
    $facilityId = $_POST['selected_facility'];
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    }
    $date = $_POST['date'];

    // Build the SQL query dynamically based on the selected values
    $sql = "SELECT * FROM reservations WHERE 1 ORDER BY reservation_date ASC";
    if ($isApprove === 1) {
        $sql = "SELECT * FROM reservations WHERE status = 'approved'";
    }
    if ($isUser) {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM reservations WHERE user_id = '$id'";
    }

    if ($facilityId != 0) {
        $sql .= " AND facility_id = '$facilityId'";
    }

    if (isset($_POST['status'])) {
        if ($status != 0) {
            $sql .= " AND status = '$status'";
        }
    }

    if (!empty($date)) {
        $sql .= " AND reservation_date = '$date'";
    }

    // Execute the query and fetch the results
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $date = date_format(date_create($row['reservation_date']), 'd/m/Y');
        $startTime = date("g:i a", strtotime($row['start_time']));
        $endTime = date("g:i a", strtotime($row['end_time']));

        echo '<tr>';
        if (in_array('id', $displayOptions)) {
            echo '<td>' . $row['id'] . '</td>';
        }
        if (in_array('username', $displayOptions)) {
            echo '<td>' . getUsernameFromUserId($conn, $row['user_id']) . '</td>';
        }
        if (in_array('organization', $displayOptions)) {
            echo '<td>' . $row['organization'] . '</td>';
        }
        if (in_array('facility', $displayOptions)) {
            echo '<td>' . getFacilityNameById($conn, $row['facility_id']) . '</td>';
        }
        if (in_array('purpose', $displayOptions)) {
            echo '<td>' . $row['purpose'] . '</td>';
        }
        if (in_array('date', $displayOptions)) {
            echo '<td>' . $date . '</td>';
        }
        if (in_array('start_time', $displayOptions)) {
            echo '<td>' . $startTime . '</td>';
        }
        if (in_array('end_time', $displayOptions)) {
            echo '<td>' . $endTime . '</td>';
        }
        if (in_array('bid', $displayOptions)) {
            echo '<td>RM ' . $row['bid'] . '</td>';
        }
        if (in_array('status', $displayOptions)) {
            echo '<td>' . $row['status'] . '</td>';
        }
        if (in_array('edit', $displayOptions) && $row['status'] === 'pending') {
            echo '<td><a href="editMyBooking.php?booking_id=' . $row['id'] . '&facility_id=' . $row['facility_id'] . ' ">Edit</a></td>';
        }
        if (in_array('checkbox', $displayOptions) && $row['status'] === 'pending') {
            echo '<td><input type="checkbox" name="booking[]" value="' . $row['id'] . '"></td>';
        }

        echo '</tr>';
    }
}

function fetchAllBooking($conn, $displayOptions = [], $isApprove, $isUser)
{
    $sql = "SELECT * FROM reservations ORDER BY reservation_date ASC;";
    if ($isApprove === 1) {
        $sql = "SELECT * FROM reservations WHERE status= 'approved' ORDER BY reservation_date ASC;";
    }
    if ($isUser) {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM reservations WHERE user_id = '$id'";
    }
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $date = date_format(date_create($row['reservation_date']), 'd/m/Y');
        $startTime = date("g:i a", strtotime($row['start_time']));
        $endTime = date("g:i a", strtotime($row['end_time']));

        echo '<tr>';
        if (in_array('id', $displayOptions)) {
            echo '<td>' . $row['id'] . '</td>';
        }
        if (in_array('username', $displayOptions)) {
            echo '<td>' . getUsernameFromUserId($conn, $row['user_id']) . '</td>';
        }
        if (in_array('organization', $displayOptions)) {
            echo '<td>' . $row['organization'] . '</td>';
        }
        if (in_array('facility', $displayOptions)) {
            echo '<td>' . getFacilityNameById($conn, $row['facility_id']) . '</td>';
        }
        if (in_array('purpose', $displayOptions)) {
            echo '<td>' . $row['purpose'] . '</td>';
        }
        if (in_array('date', $displayOptions)) {
            echo '<td>' . $date . '</td>';
        }
        if (in_array('start_time', $displayOptions)) {
            echo '<td>' . $startTime . '</td>';
        }
        if (in_array('end_time', $displayOptions)) {
            echo '<td>' . $endTime . '</td>';
        }
        if (in_array('bid', $displayOptions)) {
            echo '<td>RM ' . $row['bid'] . '</td>';
        }
        if (in_array('status', $displayOptions)) {
            echo '<td>' . $row['status'] . '</td>';
        }
        if (in_array('edit', $displayOptions) && $row['status'] === 'pending') {
            echo '<td><a href="editMyBooking.php?booking_id=' . $row['id'] . '&facility_id=' . $row['facility_id'] . ' ">Edit</a></td>';
        }
        if (in_array('checkbox', $displayOptions) && $row['status'] === 'pending') {
            echo '<td><input type="checkbox" name="booking[]" value="' . $row['id'] . '"></td>';
        }
        echo '</tr>';
    }
}


function deleteBookingById($conn, $bookingId)
{
    $sql = "DELETE FROM reservations WHERE id = '$bookingId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
}

function updateMyBooking($conn, $bookingId, $column, $newData)
{
    // echo "$bookingId<br>$column<br>$newData";
    $sql = "UPDATE reservations SET $column = '$newData' WHERE id = '$bookingId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
}

function userProfile($conn, $id)
{
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();
    echo '<tr>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>' . $row['full_name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '</tr>';
}


function getHighestCurrentBid($conn, $facilityId, $date, $startTime, $endTime)
{
    // Assuming you have a 'bid' column in your reservations table
    $sql = "SELECT MAX(bid) AS highest_bid
        FROM reservations 
        WHERE 
        status = 'pending' AND
        facility_id = '$facilityId' AND
        reservation_date = '$date'
          AND (
            ('$startTime' >= start_time AND '$startTime' < end_time) OR
            ('$endTime' > start_time AND '$endTime' <= end_time) OR
            ('$startTime' <= start_time AND '$endTime' >= end_time)
          );";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $row = $result->fetch_assoc();

    // Check if there are no reservations matching the conditions
    if ($row['highest_bid'] === null) {
        return 0; // or any default value you want to use
    }

    return $row['highest_bid'];
}

function isBookingOverlapWithApprovedBookingById($conn, $bookingId)
{
    $row = getBookingDetailsById($conn, $bookingId);
    $sql = "SELECT COUNT(*) as count 
        FROM reservations 
        WHERE 
        status = 'approved' AND
        facility_id = '{$row['facility_id']}' AND
        reservation_date = '{$row['reservation_date']}'
          AND (
            ('{$row['start_time']}' >= start_time AND '{$row['start_time']}' < end_time) OR
            ('{$row['end_time']}' > start_time AND '{$row['end_time']}' <= end_time) OR
            ('{$row['start_time']}' <= start_time AND '{$row['end_time']}' >= end_time)
          );";

    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        return 1;
    }
    return 0;
}