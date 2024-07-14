<!-- JOB APPLICATION SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once 'functions/functions.php';
$pdo = databaseConnection();

// Fetch job data from the database
$jobId = false;
if (isset($_GET["jobId"])) {
    $jobId = $_GET["jobId"];
}

// Fetch user data based on session variables
$userId = false;
if (isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];
}

// Define variables
$candidate_id = $candidate_fullName = $candidate_emailAddress = $companyName = $posted_jobTitle = $posted_jobLocation = $posted_jobDescription = $posted_jobEmploymentType = $posted_jobId = "";
$candidate_fullName_error = $candidate_emailAddress_error = $posted_jobTitle_error = "";

// Process data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fullName
    if (empty(trim($_POST["fullName"]))) {
        $candidate_fullName_error = "Field is required!";
    } else {
        $candidate_fullName = trim($_POST["fullName"]);
    }

    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $candidate_emailAddress_error = "Field is required";
    } else {
        $candidate_emailAddress = trim($_POST["emailAddress"]);
    }

    // Fetch posted job data from the database
    $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE jobId = $jobId");
    $sql->execute();
    $posted_job_data = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posted_job_data as $jobData) :
        // Company Name
        $companyName = $jobData["companyName"];

        // Posted Job Title
        $posted_jobTitle = $jobData["jobTitle"];

        // Posted Job Location
        $posted_jobLocation = $jobData["jobLocation"];

        // Posted jobDescription
        $posted_jobDescription = $jobData["jobDescription"];

        // Posted job employment type
        $posted_jobEmploymentType = $jobData["jobEmploymentType"];

    endforeach;

    // Check for errors before dealing with the database
    if (empty($candidate_fullName_error) && empty($candidate_emailAddress_error) && empty($posted_jobTitle_error)) {
        // Prepare an INSERT statament
        $sql = "INSERT INTO job_applications(candidateName, candidateEmailAddress, candidateId, companyName, posted_jobTitle, posted_jobLocation, posted_jobDescription, posted_jobEmploymentType, posted_jobId) 
        VALUES(:candidateName, :candidateEmailAddress, :candidateId, :companyName, :posted_jobTitle, :posted_jobLocation, :posted_jobDescription, :posted_jobEmploymentType, :posted_jobId)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables
            $stmt->bindParam(":candidateName", $param_candidateName, PDO::PARAM_STR);
            $stmt->bindParam(":candidateEmailAddress", $param_candidateEmailAddress, PDO::PARAM_STR);
            $stmt->bindParam(":candidateId", $param_candidateId, PDO::PARAM_INT);
            $stmt->bindParam(":companyName", $param_companyName, PDO::PARAM_STR);
            $stmt->bindParam(":posted_jobTitle", $param_posted_jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(":posted_jobLocation", $param_posted_jobLocation, PDO::PARAM_STR);
            $stmt->bindParam(":posted_jobDescription", $param_posted_jobDescription, PDO::PARAM_STR);
            $stmt->bindParam(":posted_jobEmploymentType", $param_posted_jobEmploymentType, PDO::PARAM_STR);
            $stmt->bindParam(":posted_jobId", $param_posted_jobId, PDO::PARAM_INT);

            // Set parameters
            $param_candidateName = $candidate_fullName;
            $param_candidateEmailAddress = $candidate_emailAddress;
            $param_candidateId = $userId;
            $param_companyName = $companyName;
            $param_posted_jobTitle = $posted_jobTitle;
            $param_posted_jobLocation = $posted_jobLocation;
            $param_posted_jobDescription = $posted_jobDescription;
            $param_posted_jobEmploymentType = $posted_jobEmploymentType;
            $param_posted_jobId = $jobId;

            // Attempt to execute
            if ($stmt->execute()) {
                echo "<script>alert('Job application was sent successfully!')</script>";
            } else {
                echo "There was an error during job application!";
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('JOBS | JOB APPLICATION'); ?>

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
            <script>
                function goback() {
                    window.history.back();
                }
            </script>
            <span><a href="index.php?page=home">Home</a> | <a onclick="goback()" style="cursor: pointer;">Previous</a> | Job application user details confirmation</span>
        </div>
    </div>
</div>

<!-- Section title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">User Details Confirmation</h4>
        </div>
    </div>
</div>

<!-- Details Confirmation -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Confirm your details</h3>
                <hr>

                <!-- Fetch user data from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM users WHERE userId = $userId");
                $sql->execute();
                $user_database_data = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <form action="index.php?page=jobs/job_application&jobId=<?php echo $jobId; ?>" method="post" class="login_form">
                    <?php foreach ($user_database_data as $database_data) : ?>
                        <div class="row">
                            <!-- FullName -->
                            <div class="col-6">
                                <div class="form-group my-2">
                                    <label for="FullName">Full Name</label>
                                    <input type="text" name="fullName" value="<?= $database_data["userName"]; ?>" class="form-control <?php echo (!empty($candidate_fullName_error)) ? 'is-invalid' : ''; ?>" readonly>
                                    <span class="errors text-danger"><?php echo $candidate_fullName_error; ?></span>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-6">
                                <div class="form-group my-2">
                                    <label for="emailAddress">Email Address</label>
                                    <input type="email" name="emailAddress" value="<?= $database_data["emailAddress"]; ?>" class="form-control <?php echo (!empty($candidate_emailAddress_error)) ? 'is-invalid' : ''; ?>" readonly>
                                    <span class="errors text-danger"><?php echo $candidate_emailAddress_error; ?></span>
                                </div>
                            </div>
                        </div>


                    <?php endforeach; ?>

                    <!-- Fetch jobata based on jobId -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE jobId = $jobId");
                    $sql->execute();
                    $job_database_data = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php foreach ($job_database_data as $job_data) : ?>
                        <div class="form-group my-2">
                            <label for="JobTitle">Role you're interested in</label>
                            <input type="text" name="jobTitle" value="<?= $job_data["jobTitle"]; ?>" class="form-control <?php echo (!empty($posted_jobTitle_error)) ? 'is-invalid' : ''; ?>" readonly>
                            <span class="errors text-danger"><?php echo $posted_jobTitle_error; ?></span>
                        </div>
                    <?php endforeach; ?>

                    <!-- Apply btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Proceed to apply" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>