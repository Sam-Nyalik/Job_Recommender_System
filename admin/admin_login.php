<!-- ADMIN LOGIN SECTION -->

<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

//Define variables
$emailAddress = $password = "";
$email_error = $password_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $email_error = "Please enter your email address";
    } else {
        $emailAddress = trim($_POST["emailAddress"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for errors before dealing with the database
    if (empty($email_error) && empty($password_error)) {
        // Prepare a SELECT statement
        $sql = "SELECT admin_id, emailAddress, password FROM admin WHERE emailAddress = :email";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables as prepared statements
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = $emailAddress;
            // Attempt to execute
            if ($stmt->execute()) {
                // Check if the email address exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row['admin_id'];
                        $email = $row["emailAddress"];
                        $hashed_password = $row["password"];

                        // Verfy the password input and the one in the database
                        if (password_verify($password, $hashed_password)) {
                            // Passwords match
                            session_start();

                            $_SESSION["admin_id"] = $id;
                            $_SESSION["admin_loggedIn"] = true;

                            // Redirect admin to the dashboard
                            header("Location: index.php?page=admin/admin_dashboard");
                            exit;
                        } else {
                            // Passwords do not match
                            $password_error = "Wrong password";
                        }
                    }
                } else {
                    $email_error = "User with this email address does not exist";
                }
            }
        }

        unset($stmt);
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | LOGIN'); ?>

<!-- Navbar Template -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > Admin Login</span>
        </div>
    </div>
</div>

<!-- Admin Login -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Admin Login</h3>
                <p>Manage the operations of the entire web application</p>
                <hr>

                <!-- Login Form -->
                <form action="index.php?page=admin/admin_login" method="post" class="login_form">
                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $email_error; ?></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group my-3">
                        <label for="Password">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $password_error; ?></span>
                    </div>

                    <!-- Sign In button -->
                    <div class="form-group my-4">
                        <input type="submit" value="Sign In" class="btn w-100 text-center">
                    </div>

                    <!-- <div class="form-group my-4 text-center">
                        <span>New admin?</span><a href="index.php?page=admin/admin_register"> Register</a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>