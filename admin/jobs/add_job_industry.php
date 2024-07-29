<!-- ADD JOB INDUSTRY SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check whether admin loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$industry_name = "";
$industry_name_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate industry name input
    if (empty(trim($_POST["job_industry"]))) {
        $industry_name_error = "Field is required!";
    } else {
        // check if the name already exists or not
        $sql = "SELECT * FROM job_industries WHERE industryName = :name";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $param_name = trim($_POST["job_industry"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $industry_name_error = "Job industry name already exists!";
                } else {
                    $industry_name = trim($_POST["job_industry"]);
                }
            }
        }

        unset($stmt);
    }

    // Check for errors before dealing with the database
    if (empty($industry_name_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO job_industries(industryName) VALUES(:industry_name)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables
            $stmt->bindParam(":industry_name", $param_industryName, PDO::PARAM_STR);
            $param_industryName = $industry_name;
            if ($stmt->execute()) {
                // Redirect admin to the all job industries page
                header("Location: index.php?page=admin/jobs/all_job_industries");
                exit;
            }
        }
    }
}


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD JOB INDUSTRY'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > <a href="index.php?page=admin/jobs/all_job_industries">All Job Industries</a> > Add Job Industry</span>
        </div>
    </div>
</div>

<!-- Add job industry -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Add a job industry</h3>
                <hr>

                <!-- Add industry form -->
                <form action="index.php?page=admin/jobs/add_job_industry" method="post" class="login_form">
                    <!-- IndustryName -->
                    <div class="form-group my-3">
                        <label for="JobIndustry">Industry Name</label>
                        <input type="text" name="job_industry" value="<?php echo $industry_name; ?>" class="form-control <?php echo (!empty($industry_name_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $industry_name_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add Industry" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>