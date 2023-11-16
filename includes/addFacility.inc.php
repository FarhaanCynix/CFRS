<?php
include_once 'db.inc.php';
if(isset($_POST['add'])){
    $facilityName = $_POST['name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $sql = "INSERT INTO facilities(name, description, capacity, location, status) VALUES('$facilityName', '$description', '$capacity', '$location', '$status');";
    $result = $conn->query($sql);

    if(!$result){
        die();
    }

    header("Location: ../manageFacility.php?success=Facility Add Successfully");
    exit();
}