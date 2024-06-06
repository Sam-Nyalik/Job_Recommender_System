<!-- ADMIN REGISTRATION SECTION -->

<?php

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$fullName = $emailAddress = $password = $confirmPassword = "";
$fullName_error = $emailAddress_error = $password_error = $confirmPassword_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fullName
    if (empty(trim($_POST["fullName"]))) {
        $fullName_error = "Please enter your fullname";
    } else {
        $fullName = trim($_POST["fullName"]);
    }

    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $emailAddress_error = "Please enter your email address";
    } else {
        // Check if the email address is already taken
        $sql = "SELECT * FROM admin WHERE emailAddress = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["emailAddress"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Email address exists
                    $emailAddress_error = "Email address already exists";
                } else {
                    $emailAddress = trim($_POST["emailAddress"]);
                }
            }
        }

        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter your password";
    } else if (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Passwords must be at least 6 characters long";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Please confirm your password";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        // Check if both passwords match
        if (empty($password_error) && $password !== $confirmPassword) {
            $confirmPassword_error = "Passwords do not match";
        }
    }

    // Check for errors before dealing with the database
    if (empty($fullName_error) && empty($emailAddress_error) && empty($password_error) && empty($confirmPassword_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO admin(userName, emailAddress, password) VALUES(:userName, :emailAddress, :password)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables as parameters
            $stmt->bindParam(":userName", $param_userName, PDO::PARAM_STR);
            $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // Set parameters
            $param_userName = $fullName;
            $param_emailAddress = $emailAddress;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect admin to the login page
                header("Location: index.php?page=admin/admin_login");
                exit();
            } else {
                echo "There was a problem in the execution, our developer are working on it";
            }
        }

        unset($stmt);
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | REGISTER'); ?>

<!-- Navbar Template -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <dv class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > <a href="index.php?page=admin/admin_login">Admin Login</a> > Admin Registration</span>
        </div>
    </dv>
</div>

<!-- Admin Register -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Admin Registration</h3>
                <hr>

                <!-- Registration Form -->
                <form action="index.php?page=admin/admin_register" method="post" class="login_form">
                    <!-- FullName -->
                    <div class="form-group my-3">
                        <label for="fullName">FullName</label>
                        <input type="text" name="fullName" class="form-control <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $fullName_error; ?></span>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="emailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $password_error; ?></span>
                            </div>
                        </div>

                        <div class="col-5">
                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $confirmPassword_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Sign Up Button -->
                    <div class="form-group my-4">
                        <input type="submit" value="Sign Up" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>