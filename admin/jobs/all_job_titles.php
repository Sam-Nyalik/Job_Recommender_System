<!-- ALL JOB TITLES SECTION -->

<?php

// Start session
session_start();

// Check whether admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Delete job title script
$job_title_id = false;
if(isset($_GET['title_id'])){
    $job_title_id = $_GET['title_id'];
}

if(isset($_GET['title_id'])){
    $sql = "DELETE FROM job_titles WHERE id = :jobTitle_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":jobTitle_id", $param_jobTitle_id, PDO::PARAM_INT);
    $param_jobTitle_id = $job_title_id;
    if($stmt->execute()){
        echo "<script>alert('Job title has been deleted successfully!');</script>";
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL JOB TITLES'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Job Titles</span>
        </div>
    </div>
</div>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Job Titles</h4>
        </div>
    </div>
</div>

<!-- Table for all job titles -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead>
                    <td>#</td>
                    <td>Job Title</td>
                    <td>Action</td>
                </thead>
                <!-- Fetch all job titles from the database -->
                <?php 
                    $sql = $pdo->prepare("SELECT * FROM job_titles");
                    $sql->execute();
                    $all_database_job_titles = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $count = 1;
                ?>
                <?php foreach($all_database_job_titles as $database_job_titles): ?>
                <tbody>
                    <td><?=$count++; ?></td>
                    <td><?=$database_job_titles["name"];?></td>
                    <td><a href="index.php?page=admin/jobs/all_job_titles&title_id=<?=$database_job_titles['id']; ?>&del=delete" class="text-danger">Delete</a></td>
                </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link button -->
            <div class="link_button">
                <a href="index.php?page=admin/jobs/add_job_title">Add Job Title</a>
            </div>
        </div>
    </div>
</div>