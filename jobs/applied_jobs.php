<!-- APPLIED JOBS SECTION -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Check if user is loggedIn or not
if(!isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] !== true){
    // Redirect user to the login page
    header("Location: index.php?page=users/user_login");
    exit;
}

// Fetch userId from the URL
$user_id = false;
if (isset($_GET["userId"])) {
    $user_id = $_GET["userId"];
}

// Fetch application details of the user
$sql = $pdo->prepare("SELECT * FROM job_applications WHERE candidateId = $user_id");
$sql->execute();
$database_all_applied_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);
$count = 1;

?>

<!-- Header Template -->
<?= headerTemplate('USER | APPLIED JOBS'); ?>

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

<!-- Search form -->
<div id="search_form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="search" method="post">
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

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Job Applications History</h4>
        </div>
    </div>
</div>

<!-- History of previous job applications -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead>
                    <th>#</th>
                    <th>Company Hiring</th>
                    <th>Job Title</th>
                    <th>Date</th>
                    <th>Application status</th>
                </thead>

                <?php foreach ($database_all_applied_jobs as $applied_jobs) : ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $applied_jobs["companyName"]; ?></td>
                        <td><?= $applied_jobs["posted_jobTitle"]; ?></td>
                        <td><?= $applied_jobs["date_created"]; ?></td>
                        <td><?php
                            if ($applied_jobs["application_status"] == 0) {
                                echo "<span class='text-danger'>Received. Please wait for feedback</span>";
                            } elseif($applied_jobs["application_status"] == 2) {
                                echo "<span class='text-success'>Application has been declined. Please try again when there is an opening</span>";
                            } else {
                                echo "<span class='text-success'>Application approved. You will receive a call</span>";
                            }
                            ?></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>