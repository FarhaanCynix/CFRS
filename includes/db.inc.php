<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$serverName = "localhost";
$username= "root";
$password = "";
$databaseName = "reservation_facility";

if(!$conn = mysqli_connect($serverName, $username, $password, $databaseName)){
    echo "error connecting";
}