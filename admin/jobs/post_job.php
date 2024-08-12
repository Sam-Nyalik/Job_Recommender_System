<!-- JOB POSTING SECTION -->

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
$jobTitle = $job_industry = $employmentType = $jobLevel = $jobLocation = $job_salary = $qualifications = $companyHiring = $application_deadline = $jobDescription = "";
$jobTitle_error = $job_industry_error = $employmentType_error = $jobLevel_error = $jobLocation_error = $job_salary_error = $qualifications_error = $companyHiring_error = $application_deadline_error = $jobDescription_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate job title
    if (empty(trim($_POST["jobTitle"]))) {
        $jobTitle_error = "Field is required!";
    } else {
        $jobTitle = trim($_POST["jobTitle"]);
    }

    // Validate job industry
    if(empty(trim($_POST['job_industry']))){
        $job_industry_error = "Field is required!";
    } else {
        $job_industry = trim($_POST["job_industry"]);
    }

    // Validate employment type
    if (empty(trim($_POST["employmentType"]))) {
        $employmentType_error = "Field is required!";
    } else {
        $employmentType = trim($_POST["employmentType"]);
    }

    // Validate job level
    if (empty(trim($_POST["jobLevel"]))) {
        $jobLevel_error = "Field is required!";
    } else {
        $jobLevel = trim($_POST["jobLevel"]);
    }

    // Validate job location
    if (empty(trim($_POST["jobLocation"]))) {
        $jobLocation_error = "Field is required!";
    } else {
        $jobLocation = trim($_POST["jobLocation"]);
    }

    // Validate job salary
    if (empty(trim($_POST["salary"]))) {
        $job_salary_error = "Field is required!";
    } else {
        $job_salary = trim($_POST["salary"]);
    }

    // Validate qualifications
    if (empty(trim($_POST["coreQualifications"]))) {
        $qualifications_error = "Field is required!";
    } else {
        $qualifications = trim($_POST["coreQualifications"]);
    }

    // Validate company hiring
    if (empty(trim($_POST["companyHiring"]))) {
        $companyHiring_error = "Field is required!";
    } else {
        $companyHiring = trim($_POST["companyHiring"]);
    }

    // Validate application deadline
    if (empty(trim($_POST["applicationDeadline"]))) {
        $application_deadline_error = "Field is required!";
    } else {
        $application_deadline = trim($_POST["applicationDeadline"]);
    }

    // Validate job description
    if (empty(trim($_POST["jobDescription"]))) {
        $jobDescription_error = "Field is required!";
    } else {
        $jobDescription = trim($_POST["jobDescription"]);
    }

    // Check for errors before dealing with the database
    if (empty($jobTitle_error) && empty($employmentType_error) && empty($jobLevel_error) && empty($jobLocation_error) && empty($job_salary_error) && empty($qualifications_error) && empty($companyHiring_error) && empty($application_deadline_error) && empty($jobDescription_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO posted_jobs(jobTitle, jobDescription, jobEmploymentType, companyName, coreQualifications, status, jobLocation, job_level, job_salary, application_deadline, job_industry) VALUES(:jobTitle, :jobDescription, :jobEmploymentType, :companyName, :coreQualifications, :status, :jobLocation, :jobLevel, :job_salary, :application_deadline, :job_industry)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":jobTitle", $param_jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(":jobDescription", $param_jobDescription, PDO::PARAM_STR);
            $stmt->bindParam(":jobEmploymentType", $param_jobEmploymentType, PDO::PARAM_STR);
            $stmt->bindParam(":companyName", $param_companyName, PDO::PARAM_STR);
            $stmt->bindParam(":coreQualifications", $param_coreQualifications, PDO::PARAM_STR);
            $stmt->bindParam(":status", $param_status, PDO::PARAM_INT);
            $stmt->bindParam(":jobLocation", $param_jobLocation, PDO::PARAM_STR);
            $stmt->bindParam(":jobLevel", $param_job_level, PDO::PARAM_STR);
            $stmt->bindParam(":job_salary", $param_job_salary, PDO::PARAM_STR);
            $stmt->bindParam(":application_deadline", $param_application_deadline, PDO::PARAM_STR);
            $stmt->bindParam(":job_industry", $param_job_industry, PDO::PARAM_STR);
            // Set parameters
            $param_jobTitle = $jobTitle;
            $param_jobDescription = $jobDescription;
            $param_jobEmploymentType = $employmentType;
            $param_companyName = $companyHiring;
            $param_coreQualifications = $qualifications;
            $param_status = 1;
            $param_jobLocation = $jobLocation;
            $param_job_level = $jobLevel;
            $param_job_salary = $job_salary;
            $param_application_deadline = $application_deadline;
            $param_job_industry = $job_industry;
            // Attemept to execute
            if ($stmt->execute()) {
                // Redirect admin to the all job postings page
                header("Location: index.php?page=admin/jobs/all_jobs");
                exit;
            }
        }
    }
}


?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | JOB POSTING'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admn_dashboard">Dashboard</a> > <a href="index.php?page=admin/jobs/all_jobs">All Job Postings</a> > Post a job</span>
        </div>
    </div>
</div>

<!-- Add Job -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Post a new job</h3>
                <hr>

                <!-- Post new job form -->
                <form action="index.php?page=admin/jobs/post_job" method="post" class="login_form">
                    <div class="row">
                        <!-- Job Title -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="jobTitle">Job Title</label>
                                <input type="text" name="jobTitle" value="<?php echo $jobTitle; ?>" class="form-control <?php echo (!empty($jobTitle_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $jobTitle_error; ?></span>
                            </div>
                        </div>

                        <!-- Job Industry -->
                         <div class="col-6">
                            <div class="form-group my-3">
                                <label for="JobIndustry">Job Industry</label>
                                <!-- Select job industries from the database -->
                                 <?php 
                                    $sql = $pdo->prepare("SELECT * FROM job_industries");
                                    $sql->execute();
                                    $database_all_job_industries = $sql->fetchAll(PDO::FETCH_ASSOC);
                                 ?>
                                 <select name="job_industry" class="form-control <?php echo (!empty($job_industry_error)) ? 'is-invalid' : ''; ?>">
                                    <option disabled selected>Select industry</option>
                                    <?php foreach($database_all_job_industries as $job_industries): ?>
                                        <option value="<?=$job_industries['industryName']; ?>"><?=$job_industries['industryName'];?></option>
                                        <?php endforeach; ?>
                                 </select>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                        <!-- Job Employment Type -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="EmploymentType">Employment Type</label>
                                <!-- Select employment types from the database -->
                                <?php
                                $sql = $pdo->prepare("SELECT * FROM employmentType");
                                $sql->execute();
                                $database_all_employment_types = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <select name="employmentType" class="form-control <?php echo (!empty($employmentType_error)) ? 'is-invalid' : ''; ?>">
                                    <option value="Employment type" disabled selected>Select employment type</option>

                                    <?php foreach ($database_all_employment_types as $employment_types) : ?>
                                        <option value="<?= $employment_types['employmentType_name']; ?>"><?= $employment_types['employmentType_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="errors text-danger"><?php echo $employmentType_error; ?></span>
                            </div>
                        </div>

                        <!-- Job Level -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="Job Level">Job Level</label>
                                <select name="jobLevel" class="form-control <?php echo (!empty($jobLevel_error)) ? 'is-invalid' : ''; ?>">
                                    <!-- Fetch job levels rom the database -->
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM job_levels");
                                    $sql->execute();
                                    $database_all_job_levels = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <option value="Job level" disabled selected>Select job level</option>
                                    <?php foreach ($database_all_job_levels as $all_job_levels) : ?>
                                        <option value="<?= $all_job_levels['name']; ?>"><?= $all_job_levels['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="errors text-danger">
                                    <php echo $jobLevel_error; ?>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Job Location -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="Job Location">Job Location</label>

                                <?php
                                $sql = $pdo->prepare("SELECT * FROM counties");
                                $sql->execute();
                                $database_all_counties = $sql->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <select name="jobLocation" class="form-control <?php echo (!empty($jobLocation_error)) ? 'is-invalid' : ''; ?>">
                                    <option value="Job location" disabled selected>Select job location</option>
                                    <?php foreach ($database_all_counties as $all_counties) : ?>
                                        <option value="<?= $all_counties['county_name']; ?>"><?= $all_counties['county_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="errors text-danger"><?php echo $jobLocation_error; ?></span>
                            </div>
                        </div>

                        <!-- Job Salary -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="JobSalary">Job Salary (in Ksh)</label>
                                <input type="text" name="salary" value="<?php echo $job_salary; ?>" class="form-control <?php echo (!empty($job_salary_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $job_salary_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Name of company hiring -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="companyHiring">Company Hiring</label>
                                <input type="text" name="companyHiring" value="<?php echo $companyHiring; ?>" class="form-control <?php echo (!empty($companyHiring_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $companyHiring_error; ?></span>
                            </div>
                        </div>

                        <!-- Application Deadline -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="applicationDeadline">Application Deadline</label>
                                <input type="date" name="applicationDeadline" value="<?php echo $application_deadline; ?>" class="form-control <?php echo (!empty($application_deadline_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $application_deadline_error ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Qualifications -->
                    <div class="form-group my-3">
                        <label for="Core Qualifications">Qualifications required</label>
                        <textarea name="coreQualifications" class="form-control <?php echo (!empty($qualifications_error)) ? 'is-invalid' : ''; ?>"><?php echo $qualifications; ?></textarea>
                        <span class="errors text-danger"><?php echo $qualifications_error; ?></span>
                    </div>

                    <!-- Job description -->
                    <div class="form-group my-3">
                        <label for="jobDescription">Job description</label>
                        <br>
                        <textarea name="jobDescription" class="form-control <?php echo (!empty($jobDescription_error)) ? 'is-invalid' : ''; ?>"><?php echo $jobDescription; ?></textarea>
                        <span class="errors text-danger"><?php echo $jobDescription_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Post job" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>