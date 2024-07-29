<!-- INDIVIDUAL COMPANY JOBS SECTION -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch job details based on the company name in the URL
$company_name = false;
if (isset($_GET["companyName"])) {
    $company_name = $_GET["companyName"];
}

$sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE companyName LIKE '%$company_name%' AND status = 1");
$sql->execute();
$database_company_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Header Template -->
<?= headerTemplate('JOBS | ' . $company_name); ?>

<!-- Homepage Navbar -->
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

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> | <a href="index.php?page=jobs/companies_hiring">Companies Hiring</a> |  <?= $company_name; ?></span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center"><?= $company_name; ?> Jobs Available</h4>
        </div>
    </div>
</div>

<!-- Jobs display -->
<div id="job_display">
    <div class="container">
        <div class="row">
            <?php foreach ($database_company_jobs as $company_jobs) : ?>
                <div class="job_links col-md-12">
                    <a href="">
                        <h1><?= $company_jobs["jobTitle"]; ?></h1>
                    </a>
                    <hr>
                    <h6><span style="font-weight: bold;">Company Name:</span> <span style="font-weight: 300"><?= $company_jobs["companyName"]; ?></span></h6>
                    <h6><span style="font-weight: bold;">Location:</span> <span style="font-weight: 300;"><?= $company_jobs["jobLocation"]; ?></span></h6>
                    <h6><span style="font-weight: bold;">Date Posted:</span> <span style="font-weight: 300;"><?= $company_jobs["date_created"]; ?></span></h6>
                    <h6><span style="font-weight: bold;">Application Deadline:</span> <span style="font-weight: 300;"><?= $company_jobs["application_deadline"];?></span></h6>
                    <h6 style="font-weight: bold; width: fit-content"><?= $company_jobs["jobEmploymentType"]; ?></h6>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>