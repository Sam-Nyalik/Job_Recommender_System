<!-- ALL ADMIN PROFILES -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check whether admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Delete admin profile script
$admin_id = false;
if (isset($_GET['admin_id'])) {
    $admin_id = $_GET["admin_id"];
}

if (isset($_GET['del'])) {
    if ($admin_id == $_SESSION['admin_id']) {
        echo "<script>alert('You cannot delete your own account!')</script>";
    } else {
        $sql = "DELETE FROM admin WHERE admin_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $param_admin_id, PDO::PARAM_INT);
        $param_admin_id = $admin_id;
        if ($stmt->execute()) {
            echo "<script>alert('Admin profile has been deleted successfully!')</script>";
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ALL ADMINS'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > All Administrators</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">All System Administrators</h4>
        </div>
    </div>
</div>

<!-- Table for all system administrators -->
<div id="full_table_display">
    <div class="container">
        <div class="row">
            <table class="table table-hover table-bordered">
                <!-- Fetch all admins from the database -->
                <?php
                $sql = $pdo->prepare("SELECT * FROM admin");
                $sql->execute();
                $database_all_admins = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>

                <thead>
                    <th>#</th>
                    <th>Full name</th>
                    <th>Email Address</th>
                    <th>Profile Creation Date</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_admins as $all_admins) : ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_admins["userName"]; ?></td>
                        <td><?= $all_admins["emailAddress"]; ?></td>
                        <td><?= $all_admins["date_created"]; ?></td>
                        <td><a href="index.php?page=admin/other_admin/all_admins&admin_id=<?= $all_admins['admin_id']; ?>&del=delete" class="text-danger tooltips" ltip-placement="top" tooltip="Remove">Delete</a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>

            <!-- Link Button -->
            <div class="link_button">
                <a href="index.php?page=admin/other_admin/add_admin">Add Administrator</a>
            </div>
        </div>
    </div>
</div>