<?php
include_once 'functions.inc.php';
include_once 'db.inc.php';

if(isset($_POST['edit'])) {
    echo 'edit';
}

if(isset($_POST['delete'])) {
    foreach($_POST['id'] as $id){
        deleteFacilityById($conn, $id);
    }
    header("Location: ../manageFacility.php");
    exit();
}