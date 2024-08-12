<!-- JOB SEARCH SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Process form dta when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate job industry
    if (empty(trim($_POST['job_industry']))) {
        $job_industry_error = "Field is required!";
    } else {
        $job_industry = trim($_POST["job_industry"]);
    }

    // Validate counties
    if (empty(trim($_POST["location"]))) {
        $location_error = "Field is required!";
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate experience level
    if (empty(trim($_POST['experience_level']))) {
        $experience_level_error = "Field is required!";
    } else {
        $experience_level = trim($_POST["experience_level"]);
    }

    // Check for errors before dealing with the database
    if (empty($job_industry_error) && empty($location_error) && empty($experience_level_error)) {
        // Prepare a SELECT statement
        $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE job_industry LIKE '%$job_industry%' AND jobLocation LIKE '%$location%' AND job_level LIKE '%$experience_level%'");
        $sql->execute();
        $database_search_results = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('SEARCH RESULTS'); ?>

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
                            <a class="nav-link" href="index.php?page=jobs/applied_jobs&userId=<?= $user_data['userId']; ?>">Job Applications</a>
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

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Search Results</h4>
        </div>
    </div>
</div>

<!-- Job Display -->
<div id="job_display">
    <div class="container">
        <div class="row">
            <?php if (!empty($database_search_results)): ?>
                <?php foreach ($database_search_results as $search_results): ?>
                    <div class="job_links col-md-6 my-2">
                        <a href="index.php?page=jobs/individual_job&jobId=<?= $search_results['jobId']; ?>">
                            <h1><?= $search_results['jobTitle']; ?></h1>
                        </a>
                        <hr>
                        <h6><span style="font-weight: bold;">Company Name:</span> <span style="font-weight: 300"><?= $search_results["companyName"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Location:</span> <span style="font-weight: 300;"><?= $search_results["jobLocation"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Date Posted:</span> <span style="font-weight: 300;"><?= $search_results["date_created"]; ?></span></h6>
                        <h6><span style="font-weight: bold;">Application Deadline:</span> <span style="font-weight: 300;"><?= $search_results["application_deadline"]; ?></span></h6>
                        <h6 style="font-weight: bold; width: fit-content"><?= $search_results["jobEmploymentType"]; ?></h6>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h5 class="text-center">No results found</h5>
            <?php endif; ?>
        </div>
    </div>
</div>