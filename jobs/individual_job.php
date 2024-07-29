<!-- INDIVIDUAL JOB SECTION -->

<?php

// Start session
session_start();

// Error handling
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$job_id;

?>

<!-- Header Template -->
<?= headerTemplate('JOBS | MID LEVEL'); ?>

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
            <!-- Fetch data about the job from the database -->
            <?php
            $job_id = false;
            if (isset($_GET["jobId"])) {
                $job_id = $_GET["jobId"];
            }
            $sql = "SELECT * FROM posted_jobs WHERE jobId = $job_id";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute()) {
                    if ($row = $stmt->fetch()) {
                        $job_title = $row["jobTitle"];
                    }
                }
            }
            ?>
            <span><a href="index.php?page=home">Home</a> | <?php echo $job_title; ?></span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center"><span style="font-weight: bold;"><?php echo $job_title; ?></span> Position</h4>
            <hr>
        </div>
    </div>
</div>

<!-- Job Details -->
<div id="job_details">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <!-- Fetch job details from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE jobId = $job_id");
                $sql->execute();
                $database_job_details = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <h3>Job Details</h3>
                <?php foreach ($database_job_details as $details) : ?>
                    <h2>Hiring company: <span style="color: var(--tertiary-color)"><?= $details["companyName"]; ?></span></h2>
                    <div class="row">
                        <div class="col-6">
                            <h6><?= $details["jobLocation"]; ?></h3>
                        </div>
                        <div class="col-6">
                            <h6><?= $details["jobEmploymentType"]; ?></h6>
                        </div>

                        <div class="col-6">
                            <h6><span style="color: var(--primary-color)">Applications received: </span> <?php
                                                                                                            if ($details["totalApplicants"] == NULL) {
                                                                                                                echo "0";
                                                                                                            } else {
                                                                                                                $details["totalApplicants"];
                                                                                                            }
                                                                                                            ?></h6>
                        </div>
                        <div class="col-6">
                            <h6><?= $details["job_level"]; ?></h6>
                        </div>
                    </div>
                <?php endforeach ?>

                <hr>

                <h3>Job Description/Requirements</h3>
                <h5 class="my-4" style="font-weight: bold;">Description:</h5>


                <?php foreach ($database_job_details as $job_details) : ?>
                    <p><?= nl2br($job_details["jobDescription"]); ?></p>

                    <h5 class="my-4" style="font-weight: bold;">Requirements:</h5>
                    <p><?= nl2br($job_details["coreQualifications"]); ?></p>
                <?php endforeach; ?>
            </div>

            <!-- The user has to be loggedIn so as to apply -->
            <div class="col-md-5">
                <div class="form">
                    <?php
                    if (!isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] !== true) {
                    ?>
                        <h3 style="margin-bottom: 35px;">Log in to apply now</h3>
                        <a style="text-decoration: none; background-color: var(--secondary-color); padding: 15px 45px; border-radius: 50px; color: var(--main-color)" href="index.php?page=users/user_login">Login</a>
                    <?php } else {
                    ?>
                        <!-- <form action="index.php?page=jobs/job_application" method="post" class="login_form">
                            <div class="form-group my-4">
                                <input type="submit" value="Apply Now" class="btn text-center w-100">
                            </div> -->
                            <a href="index.php?page=jobs/job_application&jobId=<?php echo $job_id; ?>" class="apply_now_btn">
                                Apply Now
                            </a>
                        <?php }
                        ?>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>