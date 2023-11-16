<?php
session_start();
include_once 'includes/functions.inc.php';
include_once 'includes/db.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/manageFacility.css">
</head>

<body>
    <?php include_once 'sidebar.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1>Facility List</h1>
            <form action="includes/manageFacility.inc.php" method="post" class="table-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Facilty Name</th>
                            <th>Decsription</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        fetchAllFacility($conn, ['id', 'name', 'description', 'capacity', 'location', 'status', 'checkbox'], 0);
                        ?>
                    </tbody>
                </table>

                <button type="submit" name="edit">Edit</button>
                <button type="submit" name="delete">Delete Facility</button>
            </form>

            <h2>Add New Facility</h2>
            <?php
            if (isset($_GET['success'])) {
                echo '<p class="success">' . $_GET['success'] . '</p>';
            }
            ?>
            <div class="form-edit">
                <form action="includes/addFacility.inc.php" method="post">
                    <table>
                        <tr>
                            <td><label for="name">Facility Name: </label></td>
                            <td><input type="text" name="name" size="20"></td>
                        </tr>
                        <tr>
                            <td><label for="description">Decsription: </label></td>
                            <td><input type="text" name="description" size="20"></td>
                        </tr>
                        <tr>
                            <td><label for="capacity">Capacity: </label></td>
                            <td><input type="number" name="capacity" size="20"></td>
                        </tr>
                        <tr>
                            <td><label for="location">Location: </label></td>
                            <td><input type="text" name="location" size="20"></td>
                        </tr>
                        <tr>
                            <td><label for="status">Status: </label></td>
                            <td>
                                <select name="status">
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <button type="submit" name="add">Add New Facility</button>
                </form>
            </div>
        </div>
    </div>
</body>


</html>