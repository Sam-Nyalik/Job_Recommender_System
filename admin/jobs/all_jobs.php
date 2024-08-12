<!-- ALL JOBS SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Deactivate job script
$job_id = false;
if (isset($_GET['jobId'])) {
    $job_id = $_GET['jobId'];
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

if (isset($_GET['del'])) {
    $sql = "UPDATE posted_jobs SET status = 0 WHERE jobId = :jobId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":jobId", $param_job_id, PDO::PARAM_INT);
    $param_job_id = $job_id;
    if ($stmt->execute()) {
        echo "<script>alert('Posted Job has been deactivated successfully!'); </script>";
    }
}


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL JOB POSTINGS'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> | All Job Postings</span>
        </div>
    </div>
</div>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Job Postings</h4>
        </div>
    </div>
</div>

<!-- Table for all job postings -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch job data from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM posted_jobs");
                $sql->execute();
                $database_all_job_postings = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>Job Location</th>
                    <th>Company Hiring</th>
                    <th>Date posted</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_job_postings as $all_job_postings) : ?>
                    <tbody>

                        <td><?= $count++; ?></td>
                        <td><?= $all_job_postings["jobId"]; ?></td>
                        <td><?= $all_job_postings["jobTitle"]; ?></td>
                        <td><?= $all_job_postings["jobLocation"]; ?></td>
                        <td><?= $all_job_postings["companyName"]; ?></td>
                        <td><?= $all_job_postings["date_created"]; ?></td>
                        <td><?php
                            if ($all_job_postings["status"] == 1) {
                                echo "<span class='text-success'>Active</span>";
                            } else {
                                echo "<span class='text-danger'>Not Active</span>";
                            }
                            ?></td>
                        <td><a href="index.php?page=admin/jobs/all_jobs&jobId=<?= $all_job_postings['jobId']; ?>&del=delete" class="text-danger">Deactivate Job</a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link button -->
            <div class="link_button">
                <a href="index.php?page=admin/jobs/post_job">Post a job</a>
            </div>
        </div>
    </div>
</div>