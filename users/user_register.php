<!-- USER REGISTRATION SECTION -->

<?php

// Include Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION CONFIRMATION'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > User Registration Data Confirmation</span>
        </div>
    </div>
</div>