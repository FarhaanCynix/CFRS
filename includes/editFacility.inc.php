<?php
include_once 'functions.inc.php';
include_once 'db.inc.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    if (!empty($name)) {
        updateFacility($conn, $id, "name", $name);
    }

    if (!empty($description)) {
        updateFacility($conn, $id, "description", $description);
    }

    if (!empty($capacity)) {
        updateFacility($conn, $id, "capacity", $capacity);
    }

    if (!empty($location)) {
        updateFacility($conn, $id, "location", $location);
    }

    if (!empty($status)) {
        updateFacility($conn, $id, "status", $status);
    }

    header("Location: ../editFacility.php?id=$id");
    exit();
}

if (isset($_POST['back'])) {
    $id = $_POST['id'];
    header("Location: ../manageFacility.php");
    exit();
}
