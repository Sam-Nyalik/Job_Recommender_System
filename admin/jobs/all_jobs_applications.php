<!-- ALL JOB APPLICATIONS SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is loggedIn
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL JOB APPLICATIONS'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Job Applications</span>
        </div>
    </div>
</div>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Job Applications</h4>
        </div>
    </div>
</div>

<!-- Table for all job applications -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch all job applications from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM job_applications WHERE application_status = 0");
                $sql->execute();
                $database_all_job_applications = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>

                <thead>
                    <th>#</th>
                    <th>Candidate Name</th>
                    <th>Candidate Email Address</th>
                    <!-- <th>Candidate Resume</th> -->
                    <th>Company Hiring</th>
                    <th>Job Title</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_job_applications as $job_applications) :
                    $candidate_email = $job_applications["candidateEmailAddress"];
                ?>

                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $job_applications["candidateName"]; ?></td>
                        <td><?= $job_applications["candidateEmailAddress"]; ?></td>
                        <td><?= $job_applications["companyName"]; ?></td>
                        <td><?= $job_applications["posted_jobTitle"]; ?></td>
                        <td><a href="index.php?page=admin/jobs/individual_job_application&applicationId=<?= $job_applications['jobApplicationId']; ?>&postedJobId=<?=$job_applications['posted_jobId'];?>&candidateId=<?= $job_applications['candidateId']; ?>">View More</a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>