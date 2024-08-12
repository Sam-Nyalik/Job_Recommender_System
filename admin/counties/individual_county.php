<!-- INDIVIDUAL COUNTY SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check whether admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch county id from the url
$county_id = false;
if (isset($_GET["countyId"])) {
    $county_id = $_GET["countyId"];
}

// Fetch county details from the database
$sql = "SELECT * FROM counties WHERE id = :county_id";
if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":county_id", $param_countyId, PDO::PARAM_INT);
    $param_countyId = $county_id;
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                // CountyName
                $county_name = $row['county_name'];
            }
        }
    }
}

// Define variables
$countyName = "";
$countyName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate countyName
    if (empty(trim($_POST["countyName"]))) {
        $countyName_error = "Field is required!";
    } else {
        // Check if the county name exists
        $sql = "SELECT * FROM counties WHERE county_name = :countyName";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables
            $stmt->bindParam(":countyName", $param_countyName, PDO::PARAM_STR);
            // Set parameters
            $param_countyName = trim($_POST["countyName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // County name exists, generate an error
                    $countyName_error = "County name already exists!";
                } else {
                    $countyName = trim($_POST["countyName"]);
                }
            }
        }
        unset($stmt);
    }

    // Check for errors before dealing with the database
    if(empty($countyName_error)){
        // Prepare an UPDATE statement
        $sql = "UPDATE counties SET county_name = :county_name WHERE id = :county_id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables
            $stmt->bindParam(":county_name", $param_county_name, PDO::PARAM_STR);
            $stmt->bindParam(":county_id", $param_county_id, PDO::PARAM_INT);
            // Set parameters
            $param_county_name = $countyName;
            $param_county_id = $county_id;
            // Attempt to execute
            if($stmt->execute()){
                echo "<script>alert('County name has been updated successfully!')</script";
            }

        }

        unset($stmt);
    }


}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ' . $county_name . ' County'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> | <a href="index.php?page=admin/counties/all_counties">All counties</a> | <?php echo $county_name; ?> County</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center"><?php echo $county_name; ?> County</h4>
        </div>
    </div>
</div>

<!-- Update counties -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>County Name</h3>
                <hr>

                <!-- Update county name -->
                <form action="index.php?page=admin/counties/individual_county&countyId=<?php echo $county_id; ?>" method="post" class="login_form">
                    <!-- Name -->
                    <div class="form-group my-3">
                        <label for="County Name">Name</label>
                        <input type="text" name="countyName" value="<?php echo $county_name; ?>" class="form-control <?php echo (!empty($countyName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $countyName_error; ?></span>
                    </div>

                    <!-- Update btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Update county" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>