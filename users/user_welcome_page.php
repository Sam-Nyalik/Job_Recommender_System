<!-- USER WELCOME PAGE -->

<?php

// Start session
session_start();

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$emailAddress = $password = $fullName = $profilePhoto = $cv = $countyName = $recentJobTitle = $employmentType = $mostRecentCompany = $expertise = $previousEmployee_true = $universityName = $courseName = $startYear = $endYear = $student_true = $preferredJobTitle = $preferredLocation = "";
$emailAddress_error = $password_error = $fullName_error = $profilePhoto_error = $cv_error = $countyName_error = $recentJobTitle_error = $employmentType_error = $mostRecentCompany_error = $expertise_error = $previousEmployee_true_error = $universityName_error = $courseName_error = $startYear_error = $endYear_error = $student_true_error = $preferredJobTitle_error = $preferredLocation_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate emailAddress
    if (!isset($_SESSION["emailAddress"])) {
        echo "<script>alert('The system did not capture your email address. Please go back to registration step 1'); </script>";
    } else {
        $emailAddress = trim($_SESSION["emailAddress"]);
    }

    // Validate password
    if (!isset($_SESSION["password"])) {
        echo "<script>alert('The system did not capture your password. Please go back to registration step 1'); </script>";
    } else {
        $password = trim($_SESSION["password"]);
    }

    // Validate fullName
    if (!isset($_SESSION["fullName"])) {
        echo "<script>alert('The system did not capture your fullName. Please go back to registration step 2'); </script>";
    } else {
        $fullName = trim($_SESSION["fullName"]);
    }

    // Validate profilePhoto
    if (!isset($_SESSION["profilePhoto"])) {
        echo "<script>alert('The system did not capture your profile photo. Please go back to registration step 2'); </script>";
    } else {
        $profilePhoto = trim($_SESSION["profilePhoto"]);
    }

    // Validate cv
    if (!isset($_SESSION["cv"])) {
        echo "<script>alert('The system did not capture your resume. Please go back to registration step 2'); </script>";
    } else {
        $cv = trim($_SESSION["cv"]);
    }

    // Validate countyName
    if (!isset($_SESSION["countyName"])) {
        echo "<script>alert('The system did not capture your location. Please go back to registration step 3'); </script>";
    } else {
        $countyName = trim($_SESSION["countyName"]);
    }

    // Validate recentJobTitle
    if (!isset($_SESSION["recentJobTitle"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your recent job title. Please go back to registration step 4'); </script>";
    } else {
        $recentJobTitle = trim($_SESSION["recentJobTitle"]);
    }

    // Validate employmentType
    if (!isset($_SESSION["employmentType"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your recent employment type. Please go back to registration step 4'); </script>";
    } else {
        $employmentType = trim($_SESSION["employmentType"]);
    }

    // Validate mostRecentCompany
    if (!isset($_SESSION["mostRecentCompany"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your recent employer. Please go back to registration step 4'); </script>";
    } else {
        $mostRecentCompany = trim($_SESSION["mostRecentCompany"]);
    }

    // Validate previous employee expertise
    if (!isset($_SESSION["expertise"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your expertise as a previous employee. Please go back to registration step 4'); </script>";
    } else {
        $expertise = trim($_SESSION["expertise"]);
    }

    // Validate student universityName
    if (!isset($_SESSION["universityName"]) && $_SESSION["student_true"] == 1) {
        echo "<script>alert('The system did not capture your university name. Please go back to registration step 4'); </script>";
    } else {
        $universityName = trim($_SESSION["universityName"]);
    }

    // Validate student courseName
    if (!isset($_SESSION["courseName"]) && $_SESSION["student_true"] == 1) {
        echo "<script>alert('The system did not capture your course name. Please go back to registration step 4'); </script>";
    } else {
        $courseName = trim($_SESSION["courseName"]);
    }

    // Validate student expertise
    if (!isset($_SESSION["expertise"]) && $_SESSION["student_true"] == 1) {
        echo "<script>alert('The system did not capture your expertise as a student. Please go back to registration step 4'); </script>";
    } else {
        $expertise = trim($_SESSION["expertise"]);
    }

    // Validate university startYear
    if (!isset($_SESSION["startYear"]) && $_SESSION["student_true"] == 1) {
        echo "<script>alert('The system did not capture your university start year. Please go back to registration step 4'); </script>";
    } else {
        $startYear = trim($_SESSION["startYear"]);
    }

    // Validate university endYear
    if (!isset($_SESSION["endYear"]) && $_SESSION["student_true"] == 1) {
        echo "<script>alert('The system did not capture your university end year. Please go back to registration step 4'); </script>";
    } else {
        $endYear = trim($_SESSION["endYear"]);
    }

    // Validate preferred jobTitle
    if (!isset($_SESSION["preferredJobTitle"])) {
        echo "<script>alert('The system did not capture your preferred job title. Please go back to registration step 5'); </script>";
    } else {
        $preferredJobTitle = trim($_SESSION["preferredJobTitle"]);
    }

    // Validate preferred job location
    if (!isset($_SESSION["preferredLocation"])) {
        echo "<script>alert('The system did not capture your preferred job location. Please go back to registration step 5'); </script>";
    } else {
        $preferredLocation = trim($_SESSION["preferredLocation"]);
    }

    // Prepare an INSERT statement into the users table
    $sql = "INSERT INTO users(userName, emailAddress, password, profilePhoto, location, skills, universityAttended, universityStartYear, universityEndYear, recentJobTitle, recentEmploymentType, recentEmploymentCompany, preferredJobTitle,
    preferredJobLocation, course, student, non_student) VALUES(:userName, :emailAddress, :password, :profilePhoto, :location, :skills, :universityAttended, :universityStartYear, :universityEndYear, :recentJobTitle, :recentEmploymentType, :recentEmploymentCompany,
    :preferredJobTitle, :preferredJobLocation, :course, :student, :non_student)";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":userName", $param_userName, PDO::PARAM_STR);
        $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":profilePhoto", $param_profilePhoto, PDO::PARAM_STR);
        $stmt->bindParam(":location", $param_location, PDO::PARAM_STR);
        $stmt->bindParam(":skills", $param_skills, PDO::PARAM_STR);
        $stmt->bindParam(":universityAttended", $param_universityAttended, PDO::PARAM_STR);
        $stmt->bindParam(":universityStartYear", $param_universityStartYear, PDO::PARAM_STR);
        $stmt->bindParam(":universityEndYear", $param_universityEndYear, PDO::PARAM_STR);
        $stmt->bindParam(":recentJobTitle", $param_recentJobTitle, PDO::PARAM_STR);
        $stmt->bindParam(":recentEmploymentType", $param_recentEmploymentType, PDO::PARAM_STR);
        $stmt->bindParam(":recentEmplymentCompany", $param_recentEmploymentCompany, PDO::PARAM_STR);
        $stmt->bindParam(":preferredJobTitle", $param_preferredJobTitle, PDO::PARAM_STR);
        $stmt->bindParam(":preferredJobLocation", $param_preferredJobLocation, PDO::PARAM_STR);
        $stmt->bindParam(":course", $param_course, PDO::PARAM_STR);
        $stmt->bindParam(":student", $param_student_true, PDO::PARAM_INT);
        $stmt->bindParam(":non_student", $param_nonStudent, PDO::PARAM_INT);
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
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> | <span style="font-weight: 200;"> <a href="index.php?page=users/user_register_step1">Registration Step 1</a> </span> | <span style="font-weight: 200;"> Registration Step 2</span> |<span style="font-weight: 200;"> Registration Step 3</span> | <span style="font-weight: 200;">Registration Step 4</span> | <span style="font-weight: 200;">Registration Step 5</span> | Finish</span>
        </div>
    </div>
</div>

<!-- Finish registration form -->
<div class="form" style="margin-top: 120px;">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <!-- Title -->
                <h3>Welcome to Nyalik JRS, <span style="color: var(--tertiary-color)"> <?php echo $_SESSION["fullName"]; ?></span></h3>
                <p>Search for jobs, and make applications from wherever you are</p>

                <form action="index.php?page=users/user_welcome_page" method="post" class="login_form">
                    <!-- Finish btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Finish" class="btn w-50 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>