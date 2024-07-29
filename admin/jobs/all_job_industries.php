<!-- ALL JOB INDUSTRIES SECTION -->

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
<?= headerTemplate('ADMIN | ALL JOB INDUSTRIES'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Job Industries</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Job Industries</h4>
        </div>
    </div>
</div>

<!-- Table for all job industries -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch job industries from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM job_industries");
                $sql->execute();
                $database_all_job_industries = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>

                <thead>
                    <th>#</th>
                    <th>Industry Name</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_job_industries as $job_industries) : ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $job_industries["industryName"]; ?></td>
                        <td><a href="">View More </a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link button -->
            <div class="link_button">
                <a href="index.php?page=admin/jobs/add_job_industry">Add job industry</a>
            </div>
        </div>
    </div>
</div>