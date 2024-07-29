<!-- ADMIN DASHBOARD SECTION -->

<?php

// Start session
session_start();

// Check if the the admin is loggedIn or not
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
<?= headerTemplate("ADMIN | DASHBOARD"); ?>

<!-- Admin Dashboard Template -->
<?= adminNavbarTemplate(); ?>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Administrator Dashboard</h4>
        </div>
    </div>
</div>

<!-- Welcome Text -->
<div id="welcome_text">
    <div class="container">
        <div class="row">
            <!-- Fetch admin userName based on the admin_id -->
            <?php
            $admin_id = false;
            if (isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] == true) {
                $admin_id = $_SESSION["admin_id"];

                $sql = $pdo->prepare("SELECT * FROM admin WHERE admin_id = $admin_id");
                $sql->execute();

                $admin_userName_fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>

            <?php foreach ($admin_userName_fetch as $admin_userName) : ?>
                <h5>Welcome, <?= $admin_userName["userName"]; ?></h5>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Main Links -->
<div id="main_links">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4>Admin Profile</h4>
                <a href="">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Jobs</h4>
                <a href="index.php?page=admin/jobs/all_jobs">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Users</h4>
                <a href="index.php?page=admin/users/all_users">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Job Applications</h4>
                <a href="index.php?page=admin/jobs/all_jobs_applications">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Recruiters</h4>
                <a href="index.php?page=admin/job_recruiters/all_job_recruiters">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Counties</h4>
                <a href="index.php?page=admin/counties/all_counties">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Employment Types</h4>
                <a href="index.php?page=admin/jobs/employment_types">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Job Levels</h4>
                <a href="index.php?page=admin/jobs/all_job_levels">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Skills</h4>
                <a href="index.php?page=admin/users/all_skills">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Job Titles</h4>
                <a href="index.php?page=admin/jobs/all_job_titles">View More</a>
            </div>
            <div class="col-md-3">
                <h4>Job Industries</h4>
                <a href="index.php?page=admin/jobs/all_job_industries">View More</a>
            </div>
            <div class="col-md-3">
                <h4>All Administrators</h4>
                <a href="index.php?page=admin/accounts/admin_profiles">View More</a>
            </div>
        </div>
    </div>
</div>