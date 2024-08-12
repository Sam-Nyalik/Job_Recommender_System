<!-- ALL JOB LEVELS SECTION -->

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
<?= headerTemplate('ADMIN | ALL COUNTIES'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Job Levels</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Job Levels</h4>
        </div>
    </div>
</div>

<!-- Table for all job levels -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-hover table-bordered">
                <!-- Fetch all job levels from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM job_levels");
                $sql->execute();
                $database_all_job_levels = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>Level Name</th>
                    <!-- <th>Action</th> -->
                </thead>

                <?php foreach ($database_all_job_levels as $all_job_levels) : ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_job_levels["name"]; ?></td>
                        <!-- <td><a href="#">View More</a> </td> -->
                    </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link Button -->
            <div class="link_button">
                <a href="index.php?page=admin/jobs/add_job_level">Add Job Level</a>
            </div>
        </div>
    </div>
</div>