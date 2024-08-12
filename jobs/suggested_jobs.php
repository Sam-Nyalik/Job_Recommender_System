<!-- SUGGESTED jOBS SECTION -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('JOBS | ALL SUGGESTED JOBS'); ?>

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
                        <a class="nav-link" href="index.php?page=jobs/explore_all_jobs">Jobs</a>
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
                            <a class="nav-link" href="index.php?page=jobs/applied_jobs">Job Applications</a>
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

<!-- Search form -->
<div id="search_form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="" class="search" method="post">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Find a job</label>
                            </div>
                        </div>

                        <!-- Select Industry -->
                        <div class="col-2">
                            <div class="form-group">
                                <select name="job_industry" class="form-control">
                                    <!-- Fetch job industries -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM job_industries");
                                    $sql->execute();
                                    $database_all_job_industries = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <option disabled selected>Industry</option>
                                    <?php foreach ($database_all_job_industries as $job_industries) : ?>
                                        <option value="<?= $job_industries["industryName"]; ?>"><?= $job_industries["industryName"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Select Location -->
                        <div class="col-2">
                            <div class="form-group">
                                <select name="" class="form-control">
                                    <option disabled selected>Location</option>
                                    <!-- Fetch locations from the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM counties");
                                    $sql->execute();
                                    $database_all_counties = $sql->fetchAll(PDO::FETCH_ASSOC);

                                    ?>

                                    <?php foreach ($database_all_counties as $counties) : ?>
                                        <option value="<?= $counties['county_name']; ?>"><?= $counties["county_name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Select Experience Level -->
                        <div class="col-2">
                            <div class="form-group">
                                <select name="" class="form-control">
                                    <option selected disabled>Experience Level</option>
                                    <!-- Fetch job levels from the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM job_levels");
                                    $sql->execute();
                                    $database_all_job_levels = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($database_all_job_levels as $job_levels) : ?>
                                        <option value="<?= $job_levels['name']; ?>"><?= $job_levels["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Search btn -->
                        <div class="col-4">
                            <div class="form-group">
                                <input type="submit" value="Search" class="btn w-100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> | All Suggested Jobs</span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Suggested Jobs</h4>
        </div>
    </div>
</div>

<!-- Suggested Job display -->
<div id="job_display">
    <div class="container">
        <div class="row">
            <!-- Fetch user data from the database -->
            <?php
            $sql = $pdo->prepare("SELECT * FROM users WHERE userId = $userId");
            $sql->execute();
            $row = $sql->fetch();
            $preferred_job_title = $row['preferredJobTitle'];
            $preferred_job_location = $row['preferredJobLocation'];
            $user_skills = $row['skills'];
            ?>

            <!-- Fetch job data based on preferred_job_title, preferred_job_location, and skills -->
            <?php
            $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE jobTitle LIKE '%$preferred_job_title%' AND jobLocation LIKE '%$preferred_job_location%'");
            $sql->execute();
            $database_suggested_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (!empty($database_suggested_jobs)): ?>
                <?php foreach ($database_suggested_jobs as $suggested_jobs): ?>
                    <div class="job_links col-md-6 my-2">
                        <a href="">
                            <h1><?= $suggested_jobs['jobTitle']; ?></h1>
                        </a>
                        <h6><span style="font-weight: bold;">Company Name:</span> <span style="font-weight: 300"><?= $suggested_jobs["companyName"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Location:</span> <span style="font-weight: 300;"><?= $suggested_jobs["jobLocation"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Date Posted:</span> <span style="font-weight: 300;"><?= $suggested_jobs["date_created"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Application Deadline:</span> <span style="font-weight: 300;"><?= $suggested_jobs["application_deadline"]; ?></span></h6>
                        <h6 style="font-weight: bold; width: fit-content"><?= $suggested_jobs["jobEmploymentType"]; ?></h6>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h5 class="text-center">There are currently no suggested jobs for you. Please check back later</h5>
            <?php endif; ?>
        </div>
    </div>
</div>