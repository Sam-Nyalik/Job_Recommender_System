<!-- ADMIN PROFILE SECTION -->

<?php

// Start session
session_start();

// Check if the admin is logged in or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch admin id
$admin_id = false;
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
}

// Define variables
$userName = "";
$userName_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate userName
    if(empty(trim($_POST["userName"]))){
        $userName_error = "Field is required!";
    } else {
        $userName = trim($_POST["userName"]);
    }

    // Check for errors before dealing with the database
    if(empty($userName_error)){
        // Prepare an UPDATE statement
        $sql = "UPDATE admin SET userName = :username WHERE admin_id = :admin_id";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_userName, PDO::PARAM_STR);
            $stmt->bindParam(":admin_id", $param_admin_id, PDO::PARAM_INT);
            $param_userName = $userName;
            $param_admin_id = $admin_id;
            if($stmt->execute()){
                echo "<script>alert('Your profile has been updated successfully!'); </script>";
            }
        }
    }
}



?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | PROFILE'); ?>

<!-- Admin Dashboard template -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> | Admin profile</span>
        </div>
    </div>
</div>


<!-- Section Title -->
<div id="section_title">
    <div class="container">
        <div class="row">
            <h4 class="text-center">Administrator Profile</h4>
        </div>
    </div>
</div>

<!-- Admin details -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Admin Details</h3>
                <hr>

                <!-- Form -->
                <form action="index.php?page=admin/admin_profile" method="post" class="login_form">
                    <!-- Fetch admin data from the database -->
                    <?php
                    $sql = $pdo->prepare("SELECT * FROM admin WHERE admin_id = :adminId");
                    $sql->bindParam(":adminId", $param_admin_id, PDO::PARAM_INT);
                    $param_admin_id = $admin_id;
                    $sql->execute();
                    $database_admin_details = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php foreach ($database_admin_details as $admin_details) : ?>
                        <!-- UserName -->
                        <div class="form-group my-3">
                            <label for="UserName">Username</label>
                            <input type="text" name="userName" value="<?= $admin_details['userName']; ?>" class="form-control <?php echo (!empty($userName_error)) ? 'is-invalid' : ''; ?>">
                            <span class="errors text-danger"><?php echo $userName_error; ?></span>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group my-3">
                            <label for="EmailAddress">Email Address</label>
                            <input type="email" disabled value="<?= $admin_details['emailAddress']; ?>" class="form-control">
                        </div>

                        <!-- Update password -->
                        <a href="index.php?page=admin/admin_change_password&admin_id=<?= $admin_details["admin_id"]; ?>">Change password</a>

                        <!-- Submit btn -->
                        <div class="form-group my-4">
                            <input type="submit" value="Update profile" class="btn w-100 text-center">
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>