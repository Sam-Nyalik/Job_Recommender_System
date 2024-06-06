<!-- ADD COUNTIES SECTION -->

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
$countyName = "";
$countyName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate county name
    if (empty(trim($_POST["countyName"]))) {
        $countyName_error = "Please enter name of county!";
    } else {
        // Check if the name already exists
        $sql = "SELECT * FROM counties WHERE county_name = :county_name";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":county_name", $param_countyName, PDO::PARAM_STR);
            $param_countyName = trim($_POST["countyName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // County name is already taken, generate an error
                    $countyName_error = "Name is already taken!";
                } else {
                    $countyName = trim($_POST["countyName"]);
                }
            }
        }

        unset($stmt);
    }

    // Check for errors before dealing with the database
    if (empty($countyName_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO counties(county_name) VALUES(:countyName)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":countyName", $param_county_name, PDO::PARAM_STR);
            $param_county_name = $countyName;
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect admin to the all counties page
                header("Location: index.php?page=admin/counties/all_counties");
                exit;
            }
        }

        unset($stmt);
    }
}


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD COUNTY'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > <a href="index.php?page=admin/counties/all_counties">All Counties</a> > Add County</span>
        </div>
    </div>
</div>

<!-- Add County -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Add a County</h3>
                <hr>

                <!-- Add county form -->
                <form action="index.php?page=admin/counties/add_county" method="post" class="login_form">
                    <!-- CountyName -->
                    <div class="form-group my-3">
                        <label for="countyName">Name of county</label>
                        <input type="text" name="countyName" class="form-control <?php echo (!empty($countyName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $countyName_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add county" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>