<!-- ADD ADMINISTRATOR SECTION --

<?php

// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

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
        $fullName_error = "Field is required!";
    } else {
        $fullName = trim($_POST["fullName"]);
    }

    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $emailAddress_error = "Field is required!";
    } else {
        // Check if the emailAddress inpu exists in the db
        $sql = "SELECT * FROM admin WHERE emailAddress = :emailAddress";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
            $param_emailAddress = trim($_POST["emailAddress"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Email address already exists. Generate an error message
                    $emailAddress_error = "Email Address already exists!";
                } else {
                    $emailAddress = trim($_POST["emailAddress"]);
                }
            }
        }
        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Field is required!";
    } else if (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Passwords must contain more than 6 characters!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Field is required!";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        if (empty($password_error) && $password !== $confirmPassword) {
            $confirmPassword_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if (empty($fullName_error) && empty($emailAddress_error) && empty($password_error) && empty($confirmPassword_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO admin(userName, emailAddress, password) VALUES(:fullName, :email_address, :password)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables
            $stmt->bindParam(":fullName", $param_fullName, PDO::PARAM_STR);
            $stmt->bindParam(":email_address", $param_email_address, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // Set parameters
            $param_fullName = $fullName;
            $param_email_address = $emailAddress;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect admin to all_admins page
                header("location: index.php?page=admin/other_admin/all_admins");
                exit;
            }
        }
        unset($stmt);
    }
}

?>

<!- Header Template -->
<?= headerTemplate('ADMIN | ADD AN ADMIN'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admin_dashboard">Dashboard</a> > <a href="index.php?page=admin/other_admin/all_admins">All Admins</a> > Add an admin</span>
        </div>
    </div>
</div>

<!-- Add an administrator -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Title -->
                <h3>Add an administrator profile</h3>
                <hr>

                <!-- Add a new administrator form -->
                <form action="index.php?page=admin/other_admin/add_admin" method="post" class="login_form">
                    <!-- FullName -->
                    <div class="form-group my-3">
                        <label for="FullName">Full name</label>
                        <input type="text" name="fullName" value="<?php echo $fullName; ?>" class="form-control <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $fullName_error; ?></span>
                    </div>

                    <!-- Email Address -->
                    <div class="form-group my-3">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" value="<?php echo $emailAddress; ?>" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="Password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $password_error; ?></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for="ConfirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $confirmPassword_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add Admin" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>