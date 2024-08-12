<!-- USER WELCOME PAGE -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$emailAddress = $password = $fullName = $profilePhoto = $cv = $countyName = $recentJobTitle = $employmentType = $mostRecentCompany = $expertise = $previousEmployee_true = $universityName = $courseName = $startYear = $endYear = $student_true = $preferredJobTitle = $preferredLocation = $location_id = "";
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
        // Fetch countyName ID from the counties table
        $sql = "SELECT * FROM counties WHERE county_name = :countyName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":countyName", $param_county_name, PDO::PARAM_STR);
            $param_county_name = $countyName;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $location_id = $row['id'];
                } else {
                    echo "There was an error fetching the county name ID";
                }
            }
        }
    }

    // Validate recentJobTitle
    if (!isset($_SESSION["recentJobTitle"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your recent job title. Please go back to registration step 4'); </script>";
    } else {
        $recentJobTitle = trim($_SESSION["recentJobTitle"]);
        // Fetch job_titles ID from the job_titles table
        $sql = "SELECT * FROM job_titles WHERE name = :titleName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":titleName", $param_titleName, PDO::PARAM_STR);
            $param_titleName = $recentJobTitle;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $jobTitle_id = $row["id"];
                } else {
                    echo "There was an error fetching the job title ID";
                }
            }
        }
    }

    // Validate employmentType
    if (!isset($_SESSION["employmentType"]) && $_SESSION["previousEmployee_true"] == 1) {
        echo "<script>alert('The system did not capture your recent employment type. Please go back to registration step 4'); </script>";
    } else {
        $employmentType = trim($_SESSION["employmentType"]);
        // Fetch employment type id from the employemtType table
        $sql = "SELECT * FROM employmentType WHERE employmentType_name = :employmentTypeName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":employmentTypeName", $param_employmentTypeName, PDO::PARAM_STR);
            $param_employmentTypeName = $employmentType;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $employmentTypeName_id = $row['id'];
                } else {
                    echo "There was an error fetching the employment type name id";
                }
            }
        }
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
        // Fetch skills id from the database based on user input
        $sql = "SELECT * FROM skills WHERE skill_name = :skillName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":skillName", $param_skill_name, PDO::PARAM_STR);
            $param_skill_name = $expertise;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $previous_employee_expertise_id = $row['id'];
                } else {
                    echo "There was an error fetching skill id from the database";
                }
            }
        }
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
        // Fetch skill id from the database based on user input
        $sql = "SELECT * FROM skills WHERE skill_name = :skillName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":skillName", $param_skillName, PDO::PARAM_STR);
            $param_skillName = $expertise;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $student_expertise_id = $row['id'];
                } else {
                    echo "There was an error fetching your skill id from the database";
                }
            }
        }
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
        // Fetch jobTitle id from the database based on user input
        $sql = "SELECT * FROM job_titles WHERE name = :jobTitleName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":jobTitleName", $param_jobTitleName, PDO::PARAM_STR);
            $param_jobTitleName = $preferredJobTitle;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $preferredJobTitle_id = $row['id'];
                } else {
                    echo "There was an error fetching preffered job title id from the database";
                }
            }
        }
    }

    // Validate preferred job location
    if (!isset($_SESSION["preferredLocation"])) {
        echo "<script>alert('The system did not capture your preferred job location. Please go back to registration step 5'); </script>";
    } else {
        $preferredLocation = trim($_SESSION["preferredLocation"]);
        // Fetch county name id from the database based on user input
        $sql = "SELECT * FROM counties WHERE county_name = :countyName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":countyName", $param_countyName, PDO::PARAM_STR);
            $param_countyName = $preferredLocation;
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $preferredLocation_id = $row['id'];
                } else {
                    echo "There was an error fetching preferred location id";
                }
            }
        }
    }

    // Prepare an INSERT statement into the users table
    $sql = "INSERT INTO users(userName, emailAddress, password, profilePhoto, location, skills, universityAttended, universityStartYear, universityEndYear, recentJobTitle, recentEmploymentType, recentEmploymentCompany, preferredJobTitle,
    preferredJobLocation, course, student, non_student, skill_id, location_id, preferredJobTitle_id, preferredJobLocation_id, resume) VALUES(:userName, :emailAddress, :password, :profilePhoto, :location, :skills, :universityAttended, :universityStartYear, :universityEndYear, :recentJobTitle, :recentEmploymentType, :recentEmploymentCompany,
    :preferredJobTitle, :preferredJobLocation, :course, :student, :non_student, :skill_id, :location_id, :preferredJobTitle_id, :preferredJobLocation_id, :resume)";

    if ($stmt = $pdo->prepare($sql)) {
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
        $stmt->bindParam(":recentEmploymentCompany", $param_recentEmploymentCompany, PDO::PARAM_STR);
        $stmt->bindParam(":preferredJobTitle", $param_preferredJobTitle, PDO::PARAM_STR);
        $stmt->bindParam(":preferredJobLocation", $param_preferredJobLocation, PDO::PARAM_STR);
        $stmt->bindParam(":course", $param_course, PDO::PARAM_STR);
        $stmt->bindParam(":student", $param_student_true, PDO::PARAM_INT);
        $stmt->bindParam(":non_student", $param_nonStudent, PDO::PARAM_INT);
        $stmt->bindParam(":skill_id", $param_skill_id, PDO::PARAM_INT);
        $stmt->bindParam(":location_id", $param_location_id, PDO::PARAM_INT);
        $stmt->bindParam(":preferredJobTitle_id", $param_jobTitle_id, PDO::PARAM_INT);
        $stmt->bindParam(":preferredJobLocation_id", $param_jobLocation_id, PDO::PARAM_INT);
        $stmt->bindParam(":resume", $param_resume, PDO::PARAM_STR);

        // Set parameters
        $param_userName = $fullName;
        $param_emailAddress = $emailAddress;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_profilePhoto = $profilePhoto;
        $param_location = $countyName;
        $param_skills = $expertise;
        $param_universityAttended = $universityName;
        $param_universityStartYear = $startYear;
        $param_universityEndYear = $endYear;
        $param_recentJobTitle = $recentJobTitle;
        $param_recentEmploymentType = $employmentType;
        $param_recentEmploymentCompany = $mostRecentCompany;
        $param_preferredJobTitle = $preferredJobTitle;
        $param_preferredJobLocation = $preferredLocation;
        $param_course = $courseName;
        $param_student_true = $_SESSION["student_true"];
        $param_nonStudent = $_SESSION["previousEmployee_true"];
        $param_skill_id = $previous_employee_expertise_id;
        $param_location_id = $location_id;
        $param_jobTitle_id = $preferredJobTitle_id;
        $param_jobLocation_id = $preferredLocation_id;
        $param_resume = $cv;

        // Attempt to execute
        if ($stmt->execute()) {
            header("Location: index.php?page=users/user_login");
            exit;
        }
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
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> | <span style="font-weight: 200;"> <a href="index.php?page=users/user_register_step1">Registration Step 1</a> </span> | <span style="font-weight: 200;"> <a href="index.php?page=users/user_register_step2">Registration Step 2</a> </span> |<span style="font-weight: 200;"> <a href="index.php?page=users/user_register_step3">Registration Step 3</a></span> | <span style="font-weight: 200;"><a href="index.php?page=users/user_register_step4">Registration Step 4</a></span> | <span style="font-weight: 200;"><a href="index.php?page=users/user_register_step5">Registration Step 5</a></span> | Finish</span>
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
                        <input type="submit" value="Finish" class="btn text-center" style="width: 50%;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>