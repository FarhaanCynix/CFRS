<?php 
session_start(); 
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <!-- <link rel="stylesheet" href="css/dashboard.css"> Link to your CSS file for styling -->
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php include_once 'sidebar.php'; ?>
</body>

</html>