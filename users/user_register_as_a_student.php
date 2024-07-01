<!-- USER REGISTRATION - AS A STUDENT -->

<?php

// Start session
session_start();

// Unset non_student sessions
unset($_SESSION["recentJobTitle"]);
unset($_SESSION["employmentType"]);
unset($_SESSION["mostRecentCompany"]);
unset($_SESSION["previousEmployee_true"]);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions 
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$universityName = $course = $expertise = $startYear = $endYear = "";
$universityName_error = $course_error = $expertise_error = $startYear_error = $endYear_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate universityName
    if(empty(trim($_POST["universityName"]))){
        $universityName_error = "Please enter your university name!";
    } else {
        $universityName = trim($_POST["universityName"]);
        $_SESSION["universityName"] = $universityName;
    }

    // Validate courseName
    if(empty(trim($_POST["courseName"]))){
        $course_error = "Please enter your course name!";
    } else {
        $course = trim($_POST["courseName"]);
        $_SESSION["courseName"] = $course;
    }

    // Validate expertise
    if(empty(trim($_POST["expertiseName"]))){
        $expertise_error = "Please select your expertise!";
    } else {
        $expertise = trim($_POST["expertiseName"]);
        $_SESSION["expertise"] = $expertise;
    }

    // Validate startYear
    if(empty(trim($_POST["startYear"]))){
        $startYear_error = "Please select your university start year!";
    } else {
        $startYear = trim($_POST["startYear"]);
        $_SESSION["startYear"] = $startYear;
    }

    // Validate endYear
    if(empty(trim($_POST["endYear"]))){
        $endYear_error = "Please select your university end year!";
    } else {
        $endYear = trim($_POST["endYear"]);
        $_SESSION["endYear"] = $endYear;
    }

    // Check for errors before redirecting to the next page
    if(empty($universityName_error) && empty($course_error) && empty($expertise_error) && empty($startYear_error) && empty($endYear_error)){
        // Store the value 1 in a session variable
        $_SESSION["student_true"] = 1;
        // Redirect user to email confirmation
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
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > <span style="font-weight: 200;">Registration Step 1</span> | <span style="font-weight: 200;"> Registration Step 2</span> |<span style="font-weight: 200;"> Registration Step 3</span> | Registration Step 4 - As a student</span>
        </div>
    </div>
</div>

<!-- Education -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Your profile helps you discover new people and opportunities</h3>
                <hr>

                <!-- Registration Form -->
                <form action="index.php?page=users/user_register_as_a_student" method="post" class="login_form">
                    <!-- University -->
                    <div class="form-group my-3">
                        <label for="University">University</label>
                        <input type="text" name="universityName" class="form-control <?php echo (!empty($universityName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $universityName_error; ?></span>
                    </div>

                    <!-- Course -->
                    <div class="form-group my-3">
                        <label for="course">Course</label>
                        <input type="text" name="courseName" class="form-control <?php echo (!empty($course_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $course_error; ?></span>
                    </div>

                    <!-- Skills -->
                    <div class="form-group">
                        <label for="Expertise">Expertise</label>
                        <!-- Fetch Skills from the database -->
                        <?php
                        $sql = $pdo->prepare("SELECT * FROM skills");
                        $sql->execute();
                        $all_database_skills = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="expertiseName" class="form-control <?php echo(!empty($expertise_error)) ? 'is-invalid' : ''; ?>">
                            <option value="Select your area of expertise" disabled>Select your area of expertise</option>
                            <?php foreach ($all_database_skills as $database_skills) : ?>
                                <option value="<?= $database_skills["skill_name"]; ?>"><?= $database_skills["skill_name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="errors text-danger"><?php echo $expertise_error; ?></span>
                    </div>

                    <div class="row">
                        <!-- Start year -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="StartYear">Start Year</label>
                                <input type="date" name="startYear" class="form-control <?php echo (!empty($startYear_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $startYear_error; ?></span>
                            </div>
                        </div>

                        <!-- End year -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="EndYear">End Year/Expected</label>
                                <input type="date" name="endYear" class="form-control <?php echo (!empty($endYear_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $endYear_error; ?></span>
                            </div>
                        </div>
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