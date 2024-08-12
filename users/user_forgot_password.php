<!-- USER FORGOT PASSWORD -->

<?php

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$emailAddress = $newPassword = $confirmNewPassword = "";
$emailAddress_error = $newPassword_error = $confirmNewPassword_error = "";

// Process form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email Address
    if(empty(trim($_POST["emailAddress"]))){
        $emailAddress_error = "Field is required!";
    } else {
        // Check if email exists
        $sql = "SELECT * FROM users WHERE emailAddress = :email_address";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables
            $stmt->bindParam(":email_address", $param_email_address, PDO::PARAM_STR);
            // Set parameters
            $param_email_address = trim($_POST["emailAddress"]);
            // Attempt to execute
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    // Email exists
                    $emailAddress = trim($_POST['emailAddress']);
                } else {
                    $emailAddress_error = "User with the given email doesn't exist!";
                }
            }
        }
    }

    // Validate password
    if(empty(trim($_POST["newPassword"]))){
        $newPassword_error = "Field is required!";
    } else if(strlen(trim($_POST["newPassword"])) < 6){
        $newPassword_error = "Passwords must contain more than 6 characters!";
    } else {
        $newPassword = trim($_POST["newPassword"]);
    }

    // Validate confirmNewPassword
    if(empty(trim($_POST["confirmNewPassword"]))){
        $confirmNewPassword_error = "Field is required!";
    } else {
        $confirmNewPassword = trim($_POST["confirmNewPassword"]);

        if(empty($newPassword_error) && $newPassword !== $confirmNewPassword){
            $confirmNewPassword_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if(empty($emailAddress_error) && empty($newPassword_error) && empty($confirmNewPassword_error)){
        // Prepare an UPDATE statement
        $sql = "UPDATE users SET password = :new_password WHERE emailAddress = :emailAddress";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":new_password", $param_new_password, PDO::PARAM_STR);
            $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
            $param_new_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $param_emailAddress = $emailAddress;
            if($stmt->execute()){
                // Redirect to the login page
                header("location: index.php?page=users/user_login");
                exit;
            }
        }
    }
}
?>

<!-- Header Template -->
<?= headerTemplate('USER | FORGOT PASSWORD'); ?>

<!-- Navbar Template -->
<?= login_navbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=home">Home</a> > User Forgot Password</span>
        </div>
    </div>
</div>

<!-- User Password reset -->
 <div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                 <h3>User Password Reset</h3>
                 <hr>

                 <!-- Password reset form -->
                  <form action="index.php?page=users/user_forgot_password" method="post" class="login_form">
                    <!-- Email Address -->
                     <div class="form-group my-3">
                        <label for="Email Address">Email Address</label>
                        <input type="email" name="emailAddress" value="<?php echo $emailAddress; ?>" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                     </div>

                     <!-- New Password -->
                      <div class="form-group my-3">
                        <label for="New Password">New Password</label>
                        <input type="password" name="newPassword" class="form-control <?php echo (!empty($newPassword_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $newPassword_error; ?></span>
                      </div>

                      <!-- Confirm new password -->
                       <div class="form-group my-3">
                        <label for="Confirm New Password">Confirm New Password</label>
                        <input type="password" name="confirmNewPassword" class="form-control <?php echo (!empty($confirmNewPassword_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $confirmNewPassword_error; ?></span>
                       </div>

                       <!-- Submit button -->
                        <div class="form-group my-4">
                            <input type="submit" value="Reset Password" class="btn w-100 text-center">
                        </div>
                  </form>
            </div>
        </div>
    </div>
 </div>