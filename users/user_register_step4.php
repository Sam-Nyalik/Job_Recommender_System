<!-- USER REGISTRATION - RECENT JOB TITLE / EDUCATION -->

<?php

// Start session
session_start();

// unset student sessions
unset($_SESSION["universityName"]);
unset($_SESSION["courseName"]);
unset($_SESSION["startYear"]);
unset($_SESSION["endYear"]);
unset($_SESSION["student_true"]);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions 
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$recentJobTitle = $employmentType = $mostRecentCompany = $expertise = "";
$recentJobTitle_error = $employmentType_error = $mostRecentCompany_error = $expertise_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate recentJobTitle
    if(empty(trim($_POST["recentJobTitle"]))){
        $recentJobTitle_error = "Please enter your recent job title!";
    } else {
        $recentJobTitle = trim($_POST["recentJobTitle"]);
        $_SESSION["recentJobTitle"] = $recentJobTitle;
    }

    // Validate employmentType
    if(empty(trim($_POST["employmentType"]))){
        $employmentType_error = "Please enter your employment type!";
    } else {
        $employmentType = trim($_POST["employmentType"]);
        $_SESSION["employmentType"] = $employmentType;
    }

    // Validate mostRecentCompany
    if(empty(trim($_POST["mostRecentCompany"]))){
        $mostRecentCompany_error = "Please enter the name of your most recent company!";
    } else {
        $mostRecentCompany = trim($_POST["mostRecentCompany"]);
        $_SESSION["mostRecentCompany"] = $mostRecentCompany;
    }

    // Validate expertise
    if(empty(trim($_POST["expertise"]))){
        $expertise_error = "Please select your area of expertise!";
    } else {
        $expertise = trim($_POST["expertise"]);
        $_SESSION["expertise"] = $expertise;
    }

    // Check for errors before redirecting user to the email confirmation section
    if(empty($recentJobTitle_error) && empty($employmentType_error) && empty($mostRecentCompany_error) && empty($expertise_error)){
        // Store the value 1 in a session variable
        $_SESSION["previousEmployee_true"] = 1;
        // Redirect user to the email confirmation section
        header("Location: index.php?page=users/user_register_step5");
        exit;
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION - RECENT JOB TITLE / EDUCATION'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > <span style="font-weight: 200;">Registration Step 1</span> | <span style="font-weight: 200;"> Registration Step 2</span> |<span style="font-weight: 200;"> Registration Step 3</span> | Registration Step 4 - As a previous/current employee</span>
        </div>
    </div>
</div>

<!-- Recent Job / Education -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Your profile helps you discover new people and opportunities</h3>
                <hr>

                <!-- Registration Form -->
                <form action="index.php?page=users/user_register_step4" method="post" class="login_form">
                    <!-- recentJobTitle -->
                    <div class="form-group my-3">
                        <label for="MostRecentJobTitle">Most Recent Job Title</label>
                        <input type="text" name="recentJobTitle" class="form-control <?php echo (!empty($recentJobTitle_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $recentJobTitle_error; ?></span>
                    </div>

                    <!-- Employment Type -->
                    <div class="form-group my-3">
                        <label for="EmploymentType">Employment Type</label>
                        <!-- Select employment types from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM employmentType");
                        $sql->execute();
                        $all_database_employment_types = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="employmentType" class="form-control <?php echo (!empty($employmentType_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Select previous/current employment type" disabled>Select previous/current employment type</option>
                            <?php foreach ($all_database_employment_types as $database_employment_types) : ?>
                                <option value="<?= $database_employment_types["employmentType_name"]; ?>"><?= $database_employment_types["employmentType_name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="errors text-danger"><?php echo $employmentType_error; ?></span>
                    </div>

                    <!-- Most recent company -->
                    <div class="form-group my-3">
                        <label for="MostRecentCompany">Most Recent Company</label>
                        <input type="text" name="mostRecentCompany" class="form-control <?php echo (!empty($mostRecentCompany_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $mostRecentCompany_error; ?></span>
                    </div>

                    <!-- Expertise -->
                    <div class="form-group my-3">
                        <label for="Expertise">Expertise</label>
                        <!-- Fetch all skills from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM skills");
                        $sql->execute();
                        $all_database_skills = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="expertise" class="form-control <?php echo (!empty($expertise_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Select area of expertise" disabled>Select area of expertise</option>
                            <?php foreach ($all_database_skills as $database_skills) : ?>
                                <option value="<?= $database_skills["skill_name"]; ?>"><?= $database_skills["skill_name"]; ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="errors text-danger"><?php echo $expertise_error; ?></span>
                    </div>

                    <!-- Student Section -->
                    <div class="form-group my-3 text-center">
                        <a href="index.php?page=users/user_register_as_a_student">I'm a Student</a>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Continue" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>