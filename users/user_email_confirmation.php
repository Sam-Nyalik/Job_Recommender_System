<!-- USER EMAIL CONFIRMATION -->

<?php

// Start session
session_start();

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$email_address = $emailConfirmationCode = "";
$emailConfirmationCode_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate code
    if (empty(trim($_POST["confirmationCode"]))) {
        $emailConfirmationCode_error = "Please enter your confirmation code!";
    } else {
        $emailConfirmationCode = trim($_POST["confirmationCode"]);
    }

    // Check for errors before dealing with the database
    if (empty($emailConfirmationCode_error)) {
        $email_address = $_SESSION["email"];
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION - RECENT JOB TITLE / EDUCATION'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> | <span style="font-weight: 200;">Registration Step 1</span> | <span style="font-weight: 200;"> Registration Step 2</span> |<span style="font-weight: 200;"> Registration Step 3</span> | <span style="font-weight: 200">Registration Step 4</span> | Email confirmation</span>
        </div>
    </div>
</div>

<!-- Email Confirmation -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Confirm your email</h3>
                <p>Type in the code we sent to "<span style="font-weight: bold;"><?php echo $_SESSION["emailAddress"]; ?></span>"</p>
                <hr>

                <!-- Code Form -->
                <form action="index.php?page=users/user_email_confirmation" method="post" class="login_form">
                    <!-- Code -->
                    <div class="form-group my-3">
                        <label for="code">Code</label>
                        <input type="text" name="confirmationCode" class="form-control <?php echo (!empty($emailConfirmationCode_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailConfirmationCode_error; ?></span>
                    </div>

                    <!-- Agree and Continue Btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Agree & Continue" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Send Code btn -->
<div class="form" style="margin-top: -70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="index.php?page=users/user_confirmation_code_registration" method="post" class="login_form">
                    <div class="form-group text-center">
                       <input type="submit" value="Send code" class="btn w-50 text-center" style="background-color: var(--tertiary-color); color: var(--dark-color)">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>