<!-- ALL USERS OF THE SYSTEM SECTION -->

<?php

// Start session
session_start();

// Check if the admin is loggedIn
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL USERS'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Users</span>
        </div>
    </div>
</div>

<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All Users</h4>
        </div>
    </div>
</div>

<!-- Table for all users -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-hover">
                <!-- Fetch all users from the database -->
                <?php 
                    $sql = $pdo->prepare("SELECT * FROM users");
                    $sql->execute();
                    $database_all_user_data = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Profile creation date</th>

                    <!-- In the action, admin should be able to view user profile, and job applications -->
                    <th>Action</th> 
                 </thead>
               
                 <?php foreach($database_all_user_data as $all_user_data): ?>
                <tbody>
                   <td><?= $count++; ?></td>
                   <td><?= $all_user_data["userName"]; ?></td>
                   <td><?= $all_user_data["profileCreationDate"];?></td>
                   <td><a href="index.php?page=admin/users/individual_user&userId=<?=$all_user_data['userId'];?>">View More</a> </td>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>