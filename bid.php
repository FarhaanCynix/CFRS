<?php
session_start();
if (!$_SESSION['isBid']) {
    header("Location: ./reservation.php");
    exit();
}
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';
$facilityId = $_GET['facility_id'];
$club = $_GET['club'];
$purpose = $_GET['purpose'];
$date = $_GET['date'];
$startTime = $_GET['start_time'];
$endTime = $_GET['end_time'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>
    <?php include_once 'sidebar.php'; ?>
    <div class="main-content">
        <h1>Make Reservation</h1>
        <div class="container">
            <p>Slot available. To make a booking, you may make your bid</p>

            <form action="includes/bid.inc.php" method="post">

                <input type="hidden" name="tmp" id="tmp" value="tmp1">
                <input type="hidden" name="facility_id" id="facility_id" value="<?php echo $facilityId; ?>">
                <input type="hidden" name="club" id="club" value="<?php echo $club; ?>">
                <input type="hidden" name="purpose" id="club" value="<?php echo $purpose; ?>">
                <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
                <input type="hidden" name="start_time" id="start_time" value="<?php echo $startTime; ?>">
                <input type="hidden" name="end_time" id="end_time" value="<?php echo $endTime; ?>">

                <label for="bid">Place Your Bid</label>
                <p>Current Bid: RM<?php echo getHighestCurrentBid($conn, $facilityId, $date, $startTime, $endTime); ?></p>
                <input type="number" name="bid" min="10">

                <button type="submit" name="bidBtn">Bid</button>
                <button type="submit" name="noBidBtn">No Thanks</button>

            </form>
        </div>
    </div>

</body>

</html>