<!-- DEFAULT HOMEPAGE -->

<?php

// Start session
session_start();

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch job details from the database
// $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE status = 1");
// $sql->execute();
// $database_all_posted_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);

// 
?>

<style>
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-group {
        flex: 1;
    }
</style>

<!-- Header Template -->
<?= headerTemplate('HOME'); ?>

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
                <form action="index.php?page=job_search_results" class="search" method="post">
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
                                <span class="errors text-danger"><?php echo $job_industry_error; ?></span>
                            </div>
                        </div>

                        <!-- Select Location -->
                        <div class="col-2">
                            <div class="form-group">
                                <select name="location" class="form-control">
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
                                <span class="errors text-danger"><?php echo $location_error; ?></span>
                            </div>
                        </div>

                        <!-- Select Experience Level -->
                        <div class="col-2">
                            <div class="form-group">
                                <select name="experience_level" class="form-control">
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
                                <span class="errors text-danger"><?php echo $experience_level_error; ?></span>
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

<!-- Landing Page -->
<div id="landing_text">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="title">
                    <h1>Explore and discover <br> the right jobs for <br> you</h1>
                </div>
                <?php
                if (!isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] !== true) {
                ?>
                    <a href="index.php?page=users/user_login" class="signIn_link">Sign in with email</a>
                <?php } else {
                ?>
                    <a href="index.php?page=jobs/suggested_jobs" class="signIn_link">Suggested Jobs</a>
                <?php }
                ?>
            </div>

            <div class="col-md-6">
                <img src="images/image2.jpg" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- System workflow icons -->
<div id="workflow_steps">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2 class="text-center">System Workflow</h2>
            </div>
            <div class="col-3">
                <!-- Registration -->
                <img src="icons/add.png" height="50" class="img-fluid img-responsive">
                <h5>Register/Login</h5>
            </div>

            <div class="col-2">
                <img src="icons/right-arrow.png" alt="" class="img-fluid img-responsive">
            </div>

            <!-- View Job -->
            <div class="col-3">
                <img src="icons/data-gathering.png" alt="" class="img-fluid img-responsive">
                <h5>View Jobs</h5>
            </div>

            <div class="col-2">
                <img src="icons/right-arrow.png" alt="" class="img-fluid img-responsive">
            </div>

            <!-- Apply -->
            <div class="col-2">
                <img src="icons/apply.png" alt="" class="img-fluid img-responsive">
                <h5>Apply</h5>
            </div>
        </div>
    </div>
</div>

<!-- Suggested Job searches -->
<div id="suggested_job_searches">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>Find the right job vacancies in Kenya</h2>
            </div>
            <h5>Experience-based filtering</h5>
            <p>Find jobs that suite your experience level</p>

            <div class="row">
                <div class="col-md-4">
                    <h3>Senior Level</h3>
                    <!-- NUMBER OF ALL JOBS IN THE SENIOR LEVEL FROM THE DATABASE -->
                    <?php
                    $sql = "SELECT * FROM posted_jobs WHERE job_level LIKE '%Senior Level%' AND status = 1";
                    if ($stmt = $pdo->prepare($sql)) {
                        // Attempt to execute
                        if ($stmt->execute()) {
                            $senior_level_num_of_rows = $stmt->rowCount();
                        }
                    }

                    ?>
                    <p>Total Number: <?php echo $senior_level_num_of_rows; ?></p>
                    <a href="index.php?page=jobs/senior_level_jobs">Explore Jobs</a>
                </div>

                <div class="col-md-4">
                    <h3>Mid Level</h3>
                    <!-- NUMBER OF ALL JOBS IN THE MID LEVEL FROM THE DATABASE -->
                    <?php
                    $sql = "SELECT * FROM posted_jobs WHERE job_level LIKE '%Mid Level%' AND status = 1";
                    if ($stmt = $pdo->prepare($sql)) {
                        if ($stmt->execute()) {
                            $mid_level_num_of_rows = $stmt->rowCount();
                        }
                    }
                    ?>
                    <p>Total Number: <?php echo $mid_level_num_of_rows; ?></p>
                    <a href="index.php?page=jobs/mid_level_jobs">Explore Jobs</a>
                </div>

                <div class="col-md-4">
                    <h3>Internship & Graduate</h3>
                    <!-- NUMBER OF ALL JOBS IN THE INTERNSHIP/GEADUATE FROM THE DATABASE -->
                    <?php
                    $sql = "SELECT * FROM posted_jobs WHERE job_level LIKE '%Internship & Graduate%' AND status = 1";
                    if ($stmt = $pdo->prepare($sql)) {
                        if ($stmt->execute()) {
                            $internship_level_num_of_rows = $stmt->rowCount();
                        }
                    }
                    ?>
                    <p>Total Number: <?php echo $internship_level_num_of_rows; ?></p>
                    <a href="index.php?page=jobs/internship_level_jobs">Explore Jobs</a>
                </div>
            </div>

            <div class="explore_all_jobs">
                <a href="index.php?page=jobs/explore_all_jobs">Explore all jobs</a>
            </div>
        </div>
    </div>
</div>

<!-- Companies currently hiring -->
<div id="companies_currently_hiring">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>Companies currently hiring in Kenya</h2>
            </div>

            <!-- LIST OF ALL COMPANIES HIRING FROM THE DATABASE -->
            <?php
            $sql = $pdo->prepare("SELECT * FROM posted_jobs ORDER BY date_created DESC LIMIT 4");
            $sql->execute();
            $all_database_companies = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($all_database_companies as $companies) : ?>
                <div class="col-md-3">
                    <h5><?= $companies['companyName']; ?></h5>
                </div>
            <?php endforeach; ?>

            <div class="explore_all_jobs">
                <a href="index.php?page=jobs/companies_hiring">View all companies hiring</a>
            </div>
        </div>
    </div>
</div>

<!-- Footer Section -->
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3>Nyalik JRS</h3>
                <p>At Nyalik JRS, we leverage cutting-edge technology to connect job seekers with their ideal career opportunities. We strive to bridge the gap between employers and job seekers, ensuring a seamless and efficient hiring process for both parties.</p>
            </div>

            <div class="col-4">
                <h5>Useful Links</h5>
                <a href="index.php?page=home">Home</a><br>
                <a href="index.php?page=jobs/explore_all_jobs">All Jobs</a><br>
                <a href="index.php?page=users/user_login">Login</a>
            </div>

            <div class="col-4">
                <h5>Socials</h5>
                <img src="icons/facebook.png" class="img-fluid img-responsive"> <span>Facebook</span> <br>
                <img src="icons/twitter.png" class="img-fluid img-responsive"> <span>X</span> <br>
                <img src="icons/reddit.png" alt="" class="img-fluid img-responsive"> <span>Reddit</span>
            </div>


            <div class="copyright">
                <h5>&copy; <?php echo date('Y'); ?> Copyright. Nyalik JRS</h5>
            </div>
        </div>
    </div>
</div>