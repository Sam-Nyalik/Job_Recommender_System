<!-- ALL COUNTIES SECTION -->

<?php

// Start session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check whether admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Delete county script
if(isset($_GET['del'])){
    $sql = "DELETE FROM counties WHERE id = :county_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("county_id", $param_county_id, PDO::PARAM_INT);
    $param_county_id = $_GET["county_id"];
    if($stmt->execute()){
        echo "<script>alert('County has been deleted successfully!')</script>";
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL COUNTIES'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Counties</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Counties</h4>
        </div>
    </div>
</div>

<!-- Table for all counties -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch county names from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM counties");
                $sql->execute();
                $all_counties_in_database = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>County Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach ($all_counties_in_database as $all_counties) : ?>

                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $all_counties["county_name"]; ?></td>
                            <td><a href="index.php?page=admin/counties/individual_county&countyId=<?=$all_counties['id'];?>" class="text-success">View More</a> | <a href="index.php?page=admin/counties/all_counties&county_id=<?=$all_counties['id']; ?>&del=delete" class="text-danger tooltips" tooltip-placement="top" tooltip="Remove">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Link Button -->
            <div class="link_button">
                <a href="index.php?page=admin/counties/add_county">Add County</a>
            </div>
        </div>
    </div>
</div>