<?php
session_start();
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';

$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <title>Profile</title>
</head>

<body>
    <?php include_once 'sidebar.php'; ?>
    <div class="main-content">
        <table>
            <tr>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php
            userProfile($conn, $user_id);
            ?>
        </table>
    </div>
</body>

</html>