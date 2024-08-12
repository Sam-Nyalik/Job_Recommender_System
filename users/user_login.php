<!-- USER LOGIN SECTION -->

<?php

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$emailAddress = $password = "";
$emailAddress_error = $password_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $emailAddress_error = "Field is required!";
    } else {
        $emailAddress = trim($_POST["emailAddress"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Field is required!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for errors before dealing with the database
    if (empty($emailAddress_error) && empty($password_error)) {
        // Prepare a SELECT statement
        $sql = "SELECT userId, emailAddress, password FROM users WHERE emailAddress = :emailAddress";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
            // Set parameters
            $param_emailAddress = $emailAddress;
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    // User exists
                    if ($row = $stmt->fetch()) {
                        $userId = $row['userId'];
                        $emailAddress = $row['emailAddress'];
                        $hashed_password = $row['password'];

                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Passwords match
                            session_start();

                            // Store data in session variables
                            $_SESSION["userLoggedIn"] = true;
                            $_SESSION["userId"] = $userId;
                            $_SESSION["emailAddress"] = $emailAddress;

                            // Redirect user to the homepage
                            header("location: index.php?page=home");
                            exit;
                        } else {
                            // Passwords do not match
                            $password_error = "Wrong password!";
                        }
                    }
                } else {
                    $emailAddress_error = "User with this email address doesn't exist!";
                }
            } else {
                echo "There was an error. Please try again!";
            }
        }

        unset($stmt);
    }
}

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
                <form action="index.php?page=users/user_login" method="post" class="login_form">
                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group my-3">
                        <label for="Password">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $password_error; ?></span>
                    </div>

                    <!-- Forgot password link -->
                    <div class="form-group my-3">
                        <a href="index.php?page=users/user_forgot_password">Forgot password?</a>
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