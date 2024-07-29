<!-- SENIOR LEVEL JOB SECTION -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('JOBS | SENIOR LEVEL'); ?>

<!-- Home page navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a href="index.php?page=home" class="navbar-brand">Nyalik JRS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php
            if (!isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] !== true) {
            ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Jobs</a>
                    </li>
                    <li class="nav-item">

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=admin/admin_login">Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=users/user_login">User Sign In</a>
                    </li>
                </ul>
            <?php } else {
                // Fetch user data based on session variables
                $userId = false;
                if (isset($_SESSION["userId"])) {
                    $userId = $_SESSION["userId"];
                } else {
                    echo "UserId is not set!";
                }
                $sql = $pdo->prepare("SELECT * FROM users WHERE userId = $userId");
                $sql->execute();
                $database_user_data = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
                <?php foreach ($database_user_data as $user_data) : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Job Applications</a>
                        </li>
                        <li class="nav-item">

                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=users/user_logout" class="nav-link">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=users/user_profile" class="nav-link"> <?php
                                                                                            echo $user_data["userName"];
                                                                                            ?></a>
                        </li>
                    </ul>

            <?php
                endforeach;
            }
            ?>
        </div>
    </div>
</nav>

<!-- Job Search Section -->
<!-- <div id="job_search_section">
    <div class="container">
        <div class="row">
            <h5>Find a Job: <select name="" id=""></select></h5>
        </div>
    </div>
 </div> -->

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> | All Senior Level Jobs</span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Senior Level Jobs</h4>
        </div>
    </div>
</div>

<!-- Jobs display -->
<div id="job_display">
    <div class="container">
        <div class="row">
            <!-- Fetch all senior level jobs from the database-->
            <?php
            $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE job_level LIKE '%Senior Level%'");
            $sql->execute();
            $all_senior_level_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($all_senior_level_jobs as $senior_level_jobs) : ?>
                <?php
                if ($senior_level_jobs["status"] == 1) {
                ?>
                    <div class="job_links col-md-12 my-2">
                        <a href="index.php?page=jobs/individual_job&jobId=<?= $senior_level_jobs['jobId']; ?>">
                            <h1><?= $senior_level_jobs["jobTitle"]; ?></h1>
                        </a>
                        <hr>
                        <h6><span style="font-weight: bold;">Company Name:</span> <span style="font-weight: 300"><?= $senior_level_jobs["companyName"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Location:</span> <span style="font-weight: 300;"><?= $senior_level_jobs["jobLocation"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Date Posted:</span> <span style="font-weight: 300;"><?= $senior_level_jobs["date_created"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Application Deadline:</span> <span style="font-weight: 300;"><?= $senior_level_jobs["application_deadline"];?></span></h6>
                        <h6 style="font-weight: bold; width: fit-content"><?= $senior_level_jobs["jobEmploymentType"]; ?></h6>
                    </div>
                <?php } else {
                ?>
                    <h3 class="text-center">There are currently no jobs available. Please check back later</h3>
                <?php }
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>