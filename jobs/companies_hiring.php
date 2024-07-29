<!-- COMPANIES HIRING SECTION -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch company details from the database
$sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE status = 1");
$sql->execute();
$all_companies_hiring = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Header Template -->
<?= headerTemplate('JOBS | COMPANIES HIRING'); ?>

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
            <span><a href="index.php?page=home">Home</a> | Companies Hiring</span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All companies Hiring</h4>
        </div>
    </div>
</div>

<!-- Companies display -->
<div id="job_display">
    <div class="container">
        <div class="row">
            <?php foreach ($all_companies_hiring as $companies_hiring) : ?>
                    <div class="job_links col-md-3 text-center my-2">
                        <a href="index.php?page=jobs/company_jobs&companyName=<?=$companies_hiring['companyName'];?>">
                            <h1 style="font-size: 20px"><?=$companies_hiring["companyName"]; ?></h1>
                        </a>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>