<!-- USER REGISTRATION - REGION/LOCATION -->

<?php

// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$counties = "";
$counties_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate countyName
    if(empty(trim($_POST["countyName"]))){
        $counties_error = "Please select your county";
    } else {
        $counties = trim($_POST["countyName"]);
        $_SESSION["countyName"] = $counties;
        // Fetch county ID based on user input
    }

    // Check for errors before proceeding to the next section
    if(empty($counties_error)){
        // Redirect user to registration step 4
        header("Location: index.php?page=users/user_register_step4");
        exit;
    }
}



?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION - REGION'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > <span style="font-weight: 200;">Registration Step 1</span> | <span style="font-weight: 200;"> Registration Step 2</span> | Registration Step 3</span>
        </div>
    </div>
</div>

<!-- Region/Location -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Welcome, <?php echo $_SESSION["fullName"] ?>!, what's your location?</h3>
                <p>See people and jobs in your area</p>
                <hr>

                <!-- Registration Form -->
                <form action="index.php?page=users/user_register_step3" method="post" class="login_form">
                    <!-- Region -->
                    <div class="form-group my-3">
                        <label for="Region">Region</label>
                        <!-- Select Option to select your location -->
                        <?php
                        // Fetch counties from the database
                        $sql = $pdo->prepare("SELECT * FROM counties");
                        $sql->execute();
                        $all_counties_in_database = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="countyName" class="form-control <?php echo (!empty($counties_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Select County" disabled>Select County</option>
                            <?php foreach ($all_counties_in_database as $all_counties) : ?>
                                <option value="<?= $all_counties["county_name"]; ?>"><?= $all_counties["county_name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="errors text-danger"><?php echo $counties_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Next" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>