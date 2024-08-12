<!-- ALL SKILLS SECTION -->

<?php

// Start session
session_start();

// Check if the admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Delete skill script
$skill_id = false;
if(isset($_GET['skill_id'])){
    $skill_id = $_GET['skill_id'];
}

if(isset($_GET['del'])){
    $sql = "DELETE FROM skills WHERE id = :skillId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":skillId", $param_skillId, PDO::PARAM_INT);
    $param_skillId = $skill_id;
    if($stmt->execute()){
        echo "<script>alert('Skill has been deleted successfully!');</script>";
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL SKILLS'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Skills</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Skills</h4>
        </div>
    </div>
</div>

<!-- Table for all skills -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch skills from the database -->
                <?php
                    $sql = $pdo->prepare("SELECT * FROM skills");
                    $sql->execute();
                    $all_database_skills = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $count = 1;                ?>
                <thead>
                    <th>#</th>
                    <th>Skill Name</th>
                    <!-- <th>Action</th> -->
                </thead>

                <?php foreach($all_database_skills as $database_skills): ?>
                <tbody>
                    <td><?= $count++; ?></td>
                    <td><?= $database_skills["skill_name"]; ?></td>
                    <!-- <td><a href="#">View More</a> | <a href="index.php?page=admin/users/all_skills&skill_id=<?=$database_skills['id']; ?>&del=delete" class="text-danger">Delete</a></td> -->
                </tbody>
                <?php endforeach; ?>


            </table>
            <!-- Link button -->
            <div class="link_button">
                <a href="index.php?page=admin/users/add_skills">Add Skills</a>
            </div>
        </div>
    </div>
</div>