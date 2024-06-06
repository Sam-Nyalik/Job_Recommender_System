<!-- EMPLOYMENT TYPES SECTION -->

<?php

// Start session
session_start();

// Check whether admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | EMPLOYMENT TYPES'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > Employment Types</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Employment Types</h4>
        </div>
    </div>
</div>

<!-- Table for all employment types -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table table-bordered table-hover">
                <!-- Fetch employment types from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM employmentType");
                $sql->execute();
                $all_database_employment_types = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>

                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($all_database_employment_types as $employment_types) : ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $employment_types["employmentType_name"]; ?></td>
                        <td><a href="#">View More</a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link button -->
            <div class="link_button">
                <a href="index.php?page=admin/jobs/add_employment_type">Add Employment Type</a>
            </div>
        </div>
    </div>
</div>