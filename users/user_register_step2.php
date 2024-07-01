<!-- USER REGISTRATION - FULLNAME, PROFILE PHOTO AND RESUME UPLOAD -->

<?php
// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Initialize variables 
$fullName = $profilePhoto = $cv = "";
$fullName_error = $profilePhoto_error = $cv_error = "";

// Prcess form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fullName
    if (empty(trim($_POST["fullName"]))) {
        $fullName_error = "Please enter your full official names";
    } else {
        $fullName = trim($_POST["fullName"]);
        $_SESSION['fullName'] = $fullName;
    }

    // Ensure that there are no errors in the fullName section before uploading images
    if (empty($fullName_error)) {
        // Process profile photo upload
        if (!empty($_FILES["profilePhoto"]["name"])) {
            move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], "users/profilePhotos/" . $_FILES["profilePhoto"]["name"]);
            $profilePhoto = "users/profilePhotos/" . $_FILES["profilePhoto"]["name"];
            $_SESSION["profilePhoto"] = $profilePhoto;

            // Process CV upload
            if (!empty($_FILES["cv"]["name"])) {
                move_uploaded_file($_FILES["cv"]["tmp_name"], "users/resumes/" . $_FILES["cv"]["name"]);
                $cv = "users/resumes/" . $_FILES["cv"]["name"];
                $_SESSION["cv"] = $cv;

                // Redirect user to register step 3
                header("Location: index.php?page=users/user_register_step3");
                exit();
            } else {
                $cv_error = "Please upload your CV";
            }
        } else {
            $profilePhoto_error = "Please upload your profile photo";
        }
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION - FULLNAME, PROFILE PHOTO, RESUME'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > <span style="font-weight: 200;">Registration Step 1</span> | Registration Step 2</span>
        </div>
    </div>
</div>

<!-- FullName, Profile photo & Resume registration-->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3></h3>
                <hr>

                <!-- Registration form -->
                <form action="index.php?page=users/user_register_step2" method="POST" class="login_form" enctype="multipart/form-data">
                    <!-- FullName -->
                    <div class="form-group my-3">
                        <label for="FullName">FullName</label>
                        <input type="text" name="fullName" class="form-control <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $fullName_error; ?></span>
                    </div>

                    <!-- Profile Photo -->
                    <div class="form-group my-3">
                        <label for="profilePhoto">Profile Photo</label>
                        <input type="file" name="profilePhoto" class="form-control">
                        <span class="errors text-danger"><?php echo $profilePhoto_error; ?></span>
                    </div>

                    <!-- Resume -->
                    <div class="form-group my-3">
                        <label for="resume">CV</label>
                        <input type="file" name="cv" class="form-control">
                        <span class="errors text-danger"><?php echo $cv_error; ?></span>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" value="Next" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>