<!-- USER - PREFERRED JOB SECTION -->

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
$jobTitle = $preferredLocation = "";
$jobTitle_error = $preferredLocation_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate jobTitle
    if(empty(trim($_POST["preferredJobTitle"]))){
        $jobTitle_error = "Please select your preferred job title!";
    } else {
        $jobTitle = trim($_POST["preferredJobTitle"]);
        $_SESSION["preferredJobTitle"] = $jobTitle;
    }

    // Validate preferredLocation
    if(empty(trim($_POST["preferredLocation"]))){
        $preferredLocation_error = "Please select your preferred location!";
    } else {
        $preferredLocation = trim($_POST["preferredLocation"]);
        $_SESSION["preferredLocation"] = $preferredLocation;
    } 

    // Check for errors before redirecting to the next page
    if(empty($jobTitle_error) && empty($preferredLocation_error)){
        // Redirect user to the welcome page
        header("Location: index.php?page=users/user_welcome_page"); 
        exit;
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER - PREFERRED JOB'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> | <span style="font-weight: 200;">Registration Step 1</span> | <span style="font-weight: 200;"> Registration Step 2</span> |<span style="font-weight: 200;"> Registration Step 3</span> | <span style="font-weight: 200;">Registration Step 4</span> | Registration Step 5</span>
        </div>
    </div>
</div>

<!-- Preferred Job -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>What kind of job are you looking for?</h3>
                <hr>

                <!-- Form -->
                <form action="index.php?page=users/user_register_step5" method="post" class="login_form">
                    <!-- Job title -->
                    <div class="form-group">
                        <label for="Job Title">Job title<span class="text-danger">*</span></label>
                        <!-- Fetch job titles from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM job_titles");
                        $sql->execute();
                        $all_database_job_titles = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="preferredJobTitle" class="form-control <?php echo (!empty($jobTitle_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Select your preferred job title" disabled>Select your preferred job title</option>
                            <?php foreach ($all_database_job_titles as $database_job_titles) : ?>
                                <option value="<?=$database_job_titles['name']; ?>"><?=$database_job_titles['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="errors text-danger"><?php echo $jobTitle_error; ?></span>
                    </div>

                    <!-- Job location -->
                    <div class="form-group my-3">
                        <label for="Job Location">Job location<span class="text-danger">*</span></label>
                        <!-- Fetch locations from the counties table -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM counties");
                        $sql->execute();
                        $all_database_counties = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="preferredLocation" class="form-control <?php echo (!empty($preferredLocation_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Please select your preferred location" disabled>Please select your preferred location</option>
                            <?php foreach ($all_database_counties as $database_counties) : ?>
                                <option value="<?= $database_counties['county_name']; ?>"><?= $database_counties['county_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="errors text-danger"><?php echo $preferredLocation_error; ?></span>
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