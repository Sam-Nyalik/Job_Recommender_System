<!-- ADD JOB TITLE SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is loggedin or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables 
$titleName = "";
$titleName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate titleName
    if (empty(trim($_POST["jobTitleName"]))) {
        $titleName_error = "Please enter a job title!";
    } else {
        // check if the titleName already exists in the database
        $sql = "SELECT * FROM job_titles WHERE name = :titleName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":titleName", $param_titleName, PDO::PARAM_STR);
            $param_titleName = trim($_POST["jobTitleName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Job title name already exists, generate an error
                    $titleName_error = "Job title name already exists!";
                } else {
                    $titleName = trim($_POST["jobTitleName"]);
                }
            }
        }

        unset($stmt);
    }

    // Check for errors before dealing with the database
    if (empty($titleName_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO job_titles(name) VALUES(:title_name)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":title_name", $param_titleName, PDO::PARAM_STR);
            $param_titleName = $titleName;
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect admin to the all_job_titles page
                header("Location: index.php?page=admin/jobs/all_job_titles");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD JOB TITLE'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admn_dashboard">Dashboard</a> > <a href="index.php?page=admin/jobs/all_job_titles">All Job Titles</a> > Add Job Title</span>
        </div>
    </div>
</div>

<!-- Add Job Title -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Add a Job Title</h3>
                <hr>

                <!-- Add job title form -->
                <form action="index.php?page=admin/jobs/add_job_title" method="post" class="login_form">
                    <!-- JobTitleName -->
                    <div class="form-group">
                        <label for="titleName">Job Title Name</label>
                        <input type="text" name="jobTitleName" class="form-control <?php echo (!empty($titleName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $titleName_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add job title" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>