<?php
session_start();
include_once 'includes/db.inc.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect unauthenticated users to the login page
    exit();
}

$sql = "SELECT * FROM facilities;";
$result = $conn->query($sql)
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <!-- <link rel="stylesheet" href="css/dashboard.css"> Link to your CSS file for styling -->
    <link rel="stylesheet" href="css/sidebars.css">
    <!-- <link rel="stylesheet" href="css/dashboard.css"> -->
    <link rel="stylesheet" href="css/facilityList.css">
</head>

<body>
    <?php include_once 'sidebar.php'; ?>

    <div class="main-content">
        <div class="logo-container">
            <img src="img/UPTM_Logo.png" alt="UPTM Campus Management System" class="avatar">
        </div>
        <h2>Available Facilities</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Facility ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <!-- <th>Schedule</th>
                    <th>Action</th> Add a new column for the action -->
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] === "available") {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['capacity'] . "</td>";
                        echo "<td>" . $row['location'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
        <div class="button-container">
            <!-- <a href="schedule.php">Schedule</a> -->
            <a href="reservation.php">Make a Reservation</a>
        </div>
    </div>
</body>

</html>