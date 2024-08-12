<!-- ADMIN ANGE PASSWORD SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is logged in or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

//Fetch admin id
$admin_id = false;
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
}

// Define variables
$newPassword = $confirmNewPassword = "";
$newPassword_error = $confirmNewPassword_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate newPassword
    if (empty(trim($_POST["newPassword"]))) {
        $newPassword_error = "Field is required!";
    } else if (strlen(trim($_POST["newPassword"])) < 6) {
        $newPassword_error = "Passwords must have more than 6 characters!";
    } else {
        $newPassword = trim($_POST["newPassword"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirmNewPassword"]))){
        $confirmNewPassword_error = "Field is required!";
    } else {
        $confirmNewPassword = trim($_POST["confirmNewPassword"]);

        // Check if the two passwords match
        if(empty($newPassword_error) && $newPassword !== $confirmNewPassword){
            $confirmNewPassword_error = "Passwords do not match!";
        }

        // Check for errors before dealing with the database
        if(empty($newPassword_error) && empty($confirmNewPassword_error)){
            // Prepare an UPDATE statement
            $sql = "UPDATE admin SET password = :new_password WHERE admin_id = :adminId";
            if($stmt = $pdo->prepare($sql)){
                // Bind variables
                $stmt->bindParam(":new_password", $param_new_password, PDO::PARAM_STR);
                $stmt->bindParam(":adminId", $param_admin_id, PDO::PARAM_INT);
                // Set parameters
                $param_new_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $param_admin_id = $admin_id;
                // Attempt to execute
                if($stmt->execute()){
                    header("location: index.php?page=admin/admin_login");
                    exit;
                }
            }
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | PASSWORD RESET'); ?>

<!-- Admin Dashboard template -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> | <a href="index.php?page=admin/admin_profile">Admin Profile</a> | Admin Change Password</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Administrator Password Reset</h4>
        </div>
    </div>
</div>

<!-- Admin password reset script -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Password Reset</h3>
                <hr>

                <!-- Form -->
                <form action="index.php?page=admin/admin_change_password" method="post" class="login_form">
                    <!-- New Password -->
                    <div class="form-group my-3">
                        <label for="New Password">New Password</label>
                        <input type="password" name="newPassword" class="form-control <?php echo (!empty($newPassword_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $newPassword_error; ?></span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group my-3">
                        <label for="confirm Password">Confirm New Password</label>
                        <input type="password" name="confirmNewPassword" class="form-control <?php echo (!empty($confirmNewPassword_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $confirmNewPassword_error; ?></span>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group my-4">
                        <input type="submit" value="Change Password" class="btn w-100 text-center">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>