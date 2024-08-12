<!-- INDIVIDUAL JOB APPLICATION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is loggedIn
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch posted job details based on the ID in the URL
$posted_job_id = false;
if (isset($_GET["postedJobId"])) {
    $posted_job_id = $_GET["postedJobId"];
}

// Fetch job application id from the URL
$application_id = false;
if (isset($_GET['applicationId'])) {
    $application_id = $_GET['applicationId'];
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | INDIVIDUAL JOB APPLICATION'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> | <a href="index.php?page=admin/jobs/all_jobs_applications">All Job Applications</a> | Individual job application</span>
        </div>
    </div>
</div>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Individual Job Application</h4>
        </div>
    </div>
</div>


<!-- -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <!-- Posted Job Description -->
            <!-- Fetch posted job details from the database -->
            <?php
            $posted_jobId = false;
            if (isset($_GET['posetdJobId'])) {
                $posted_jobId = $_GET['postedJobId'];
            }
            $sql = $pdo->prepare("SELECT * FROM posted_jobs WHERE jobId = $posted_job_id");
            $sql->execute();
            $database_posted_jobs = $sql->fetchAll(PDO::FETCH_ASSOC);
            $count = 1;
            ?>
            <h3>Posted Job Details</h3>
            <table class="table table-hover table-bordered table-responsive">
                <thead>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Job Description</th>
                    <th>Job employment type</th>
                    <th>Hiring company</th>
                    <th>Qualifications required</th>
                    <th>Job location</th>
                    <th>Job level</th>
                    <th>Salary</th>
                    <th>Application deadline</th>
                </thead>

                <?php foreach ($database_posted_jobs as $posted_jobs): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $posted_jobs['jobTitle']; ?></td>
                        <td><?= $posted_jobs['jobDescription']; ?></td>
                        <td><?= $posted_jobs['jobEmploymentType']; ?></td>
                        <td><?= $posted_jobs['companyName']; ?></td>
                        <td><?= $posted_jobs['coreQualifications']; ?></td>
                        <td><?= $posted_jobs['jobLocation']; ?></td>
                        <td><?= $posted_jobs['job_level']; ?></td>
                        <td><?= $posted_jobs['job_salary']; ?></td>
                        <td><?= $posted_jobs['application_deadline']; ?></td>
                    </tbody>
                <?php endforeach; ?>
            </table>


            <h3>Candidate Details</h3>

            <!-- Fetch Candidate details from the database-->
            <?php
            $candidateId = false;
            if (isset($_GET['candidateId'])) {
                $candidateId = $_GET['candidateId'];
            }
            $sql = $pdo->prepare("SELECT * FROM users WHERE userId = $candidateId");
            $sql->execute();
            $database_candidate_details = $sql->fetchAll(PDO::FETCH_ASSOC);
            $count = 1;
            ?>

            <table class="table table-hover table-bordered table-responsive">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Location</th>
                    <th>Skills</th>
                    <th>Resume</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_candidate_details as $candidate_details): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $candidate_details['userName']; ?></td>
                        <td><?= $candidate_details['emailAddress']; ?></td>
                        <td><?= $candidate_details['location']; ?></td>
                        <td><?= $candidate_details['skills']; ?></td>
                        <td> <?php if (!empty($candidate_details['resume'])): ?>
                                <a href="<?= htmlspecialchars('' . $candidate_details['resume']); ?>" target="_blank">View Resume</a>
                            <?php else: ?>
                                No resume uploaded
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="index.php?page=admin/jobs/approve_job_application&applicationId=<?php echo $application_id; ?>&postedJobId=<?php echo $posted_job_id; ?>&candidateId=<?= $candidate_details['userId']; ?>" method="post" class="login_form">
                                <div class="form-group">
                                    <input type="submit" value="Approve Application" class="btn w-100 text-center" style="background-color: var(--tertiary-color); color: var(--basic-color);">
                                </div>
                            </form>
                            <form action="index.php?page=admin/jobs/decline_job_application&applicationId=<?php echo $application_id; ?>&postedJobId=<?php echo $posted_job_id; ?>&candidateId=<?= $candidate_details['userId']; ?>" method="post" class="login_form">
                                <div class="form-group my-3">
                                    <input type="submit" value="Decline Application" class="btn w-100 text-center" style="background-color: #ff0000; color: var(--main-color);">
                                </div>
                            </form>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>