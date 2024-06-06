<!-- USER LOGIN SECTION -->

<?php

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('USER | LOGIN'); ?>

<!-- Navbar Template -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > User Login</span>
        </div>
    </div>
</div>

<!-- User Login -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>User Sign in</h3>
                <p>Stay updated on your professional world</p>
                <hr>

                <!-- Login Form -->
                <form action="" class="login_form">
                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" class="form-control">
                    </div>

                    <!-- Password -->
                    <div class="form-group my-3">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control">
                    </div>

                    <!-- Forgot password link -->
                    <div class="form-group my-3">
                        <a href="#">Forgot password?</a>
                    </div>

                    <!-- Sign In Button -->
                    <div class="form-group my-4">
                        <input type="submit" value="Sign in" class="btn w-100 text-center">
                    </div>

                    <div class="form-group my-4 text-center">
                        <span>New to Nyalik JRS?</span><a href="index.php?page=users/user_register_step1"> Join now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>