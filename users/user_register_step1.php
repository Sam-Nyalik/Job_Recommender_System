<!-- USER REGISTRATION - EMAIL AND PASSWORD SECTION -->

<?php

// Start session
session_start();

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Initialize variables
$emailAddress = $password = $confirmPassword = "";
$emailAddress_error = $password_error = $confirmPassword_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate emailAddress
    if (empty(trim($_POST['emailAddress']))) {
        $emailAddress_error = "Please enter your email address";
    } else {
        // Check if the email address has already been taken
        $sql = "SELECT * FROM users WHERE emailAddress = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["emailAddress"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $emailAddress_error = "Email Address already exists!";
                } else {
                    // Email address doesn't exist
                    $emailAddress = trim($_POST["emailAddress"]);
                    $_SESSION["emailAddress"] = $emailAddress;
                }
            }
        }

        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter your password";
    } else if (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Passwords must be more than 6 characters long!";
    } else {
        $password = trim($_POST["password"]);
        $_SESSION["password"] = $password;
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Please confirm your password";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        if (empty($password_error) && $password !== $confirmPassword) {
            $confirmPassword_error = "Passwords do not match!";
        }
    }

    // Check for errors
    if (empty($emailAddress_error) && empty($password_error) && empty($confirmPassword_error)) {
        // Redirect user to registration step 2
        header("Location: index.php?page=users/user_register_step2");
        exit;
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('USER | REGISTRATION - EMAIL & PASSWORD'); ?>

<!-- Navbar -->
<?= login_navbarTemplate(); ?>

<!-- breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=users/user_login">User Login</a> > User Registration Step 1</span>
        </div>
    </div>
</div>

<!-- Email and Password Registration -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Make the most of your professional life</h3>
                <hr>

                <!-- Registration Form -->
                <form action="index.php?page=users/user_register_step1" method="POST" class="login_form">
                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $password_error ?></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ConfirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $confirmPassword_error;  ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" value="Next" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>