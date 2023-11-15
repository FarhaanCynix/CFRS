<?php
session_start();
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';

$row = getBookingDetailsById($conn, $_GET['booking_id']);
$highestCurrentBid = getHighestCurrentBid($conn, $row['facility_id'], $row['reservation_date'], $row['start_time'], $row['end_time']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/reservation.css">
</head>

<body>
    <?php include_once 'sidebar.php'; ?>
    <div class="main-content">
        <h1>Make Reservation</h1>
        <div class="container">
            <!-- <form action="includes/reservation.inc.php?facility_id=<?php echo $_GET['facility_id']; ?>&facility_name=<?php echo $_GET['facility_name'] ?>" method="post"> -->
            <?php
            if (isset($_GET['occupied'])) {
                echo '<p>Already Occupied</p>';
            }
            if (isset($_GET['book'])) {
                echo '<p>Change Successful. Wait for admin to approve it</p>';
            }
            ?>
            <form action="includes/editMyBooking.inc.php?booking_id=<?php echo $_GET['booking_id']; ?>" method="post">

                <label for="club">Club/Organization Name</label>
                <input type="text" name="club">

                <label for="purpose">Purpose of booking</label>
                <input type="text" name="purpose">

                <label for="date">Date:</label>
                <input type="date" name="date">

                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time">

                <label for="end_time">End Time:</label>
                <input type="time" name="end_time">

                <label for="bid">Place Your Bid</label>
                <p>Current Bid: RM<?php echo $highestCurrentBid; ?></p>
                <input type="number" name="bid" min="<?php echo $highestCurrentBid; ?>">

                <button type="submit" name="back">Back</button>
                <button type="submit" name="edit">Edit</button>
            </form>
        </div>
    </div>

</body>

</html>