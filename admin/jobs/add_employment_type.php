<!-- ADD EMPLOYMENT TYPE SECTION -->

<?php

// Start session
session_start();

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
$employmentTypeName = "";
$employmentTypeName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate employmentTypeName
    if (empty(trim($_POST["employmentTypeName"]))) {
        $employmentTypeName_error = "Please enter employment type name!";
    } else {
        // Check if the employment type already exists in the database
        $sql = "SELECT * FROM employmentType WHERE employmentType_name = :employment_name";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":employment_name", $param_employment_name, PDO::PARAM_STR);
            // Set paramaters
            $param_employment_name = trim($_POST["employmentTypeName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // EmploymentTypeName already exists, generate an error
                    $employmentTypeName_error = "Employment type name already exists!";
                } else {
                    // It doesn't exist
                    $employmentTypeName = trim($_POST["employmentTypeName"]);
                }
            }
        }
    }


    // Check for errors before dealing with the database
    if (empty($employmentTypeName_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO employmentType(employmentType_name) VALUES(:employment_type)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":employment_type", $param_employment_type, PDO::PARAM_STR);
            $param_employment_type = $employmentTypeName;
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect to the employment_types page
                header("Location: index.php?page=admin/jobs/employment_types");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD EMPLOYMENT TYPE'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admn_dashboard">Dashboard</a> > <a href="index.php?page=admin/jobs/employment_types">All Employment Types</a> > Add Employment Type</span>
        </div>
    </div>
</div>

<!-- Add Employment -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Add Employment Type</h3>
                <hr>

                <!-- Add Employment Type form -->
                <form action="index.php?page=admin/jobs/add_employment_type" method="post" class="login_form">
                    <!-- EmploymentTypeName -->
                    <div class="form-group my-3">
                        <label for="EmploymentTypeName">Employment Type</label>
                        <input type="text" name="employmentTypeName" class="form-control <?php echo (!empty($employmentTypeName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $employmentTypeName_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add Employment Type" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>