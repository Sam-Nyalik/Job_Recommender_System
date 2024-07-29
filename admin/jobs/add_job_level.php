<!-- ADD JOB LEVEL SECTION -->

<?php

// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$levelName = "";
$levelName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate level name
    if (empty(trim($_POST["levelName"]))) {
        $levelName_error = "Field is required!";
    } else {
        // Check if the job level input already exists
        $sql = "SELECT * FROM job_levels WHERE name = :job_level";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":job_level", $param_job_level, PDO::PARAM_STR);
            $param_job_level = trim($_POST["levelName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    // Name already exists
                    $levelName_error = "Job level already exists!";
                } else {
                    $levelName = trim($_POST["levelName"]);
                }
            }

            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($levelName_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO job_levels(name) VALUES(:jobLevelName)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":jobLevelName", $param_job_level_name, PDO::PARAM_STR);
            $param_job_level_name = $levelName;
            if ($stmt->execute()) {
                // redirect admin to the all job levels page
                header("location: index.php?page=admin/jobs/all_job_levels");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD JOB LEVEL'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admn_dashboard">Dashboard</a> > <a href="index.php?page=admin/jobs/all_job_levels">All Job Levels</a> > Add a Job Level</span>
        </div>
    </div>
</div>

<!-- Add a job level -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Add a new job level</h3>
                <hr>

                <!-- Add a new job level form -->
                <form action="index.php?page=admin/jobs/add_job_level" method="post" class="login_form">
                    <!-- Jobe level name -->
                    <div class="form-group my-3">
                        <label for="levelName">Level Name</label>
                        <input type="text" name="levelName" class="form-control <?php echo (!empty($levelName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $levelName_error; ?></span>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" value="Add Level" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>