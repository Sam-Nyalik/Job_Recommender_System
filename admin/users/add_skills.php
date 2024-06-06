<!-- ADD SKILLS SECTION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check whether admin loggedIn or not
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Define variables
$skillName = "";
$skillName_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate skillName
    if (empty(trim($_POST["skillName"]))) {
        $skillName_error = "Please enter name of skill!";
    } else {
        // Check whether the input skillName already exists in the database
        $sql = "SELECT * FROM skills WHERE skill_name = :skillName";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":skillName", $param_skillName, PDO::PARAM_STR);
            $param_skillName = trim($_POST["skillName"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // input skillName already exists in the database, generate an error
                    $skillName_error = "Skill already exists!";
                } else {
                    $skillName = trim($_POST["skillName"]);
                }
            }
        }

        unset($stmt);
    }

    // Check for errors before dealing with the database
    if (empty($skillName_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO skills(skill_name) VALUES(:skillName)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":skillName", $param_skill_name, PDO::PARAM_STR);
            $param_skill_name = $skillName;
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect admin to the all skill page
                header("Location: index.php?page=admin/users/all_skills");
                exit;
            }
        }

        unset($stmt);
    }
}

?>

<!-- Header Template -->
<?= headerTemplate('ADMIN | ADD SKILL'); ?>

<!-- Admin Navbar -->
<?= adminNavbarTemplate(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <span><a href="index.php?page=admin/admn_dashboard">Dashboard</a> > <a href="index.php?page=admin/users/all_skills">All Skills</a> > Add Skill</span>
        </div>
    </div>
</div>

<!-- Add Skill -->
<div class="form">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Title -->
                <h3>Add a Skill</h3>
                <hr>

                <!-- Add skill form -->
                <form action="index.php?page=admin/users/add_skills" method="post" class="login_form">
                    <!-- SkillName -->
                    <div class="form-group my-3">
                        <label for="skillName">Name of skill</label>
                        <input type="text" name="skillName" class="form-control <?php echo (!empty($skillName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $skillName_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-4">
                        <input type="submit" value="Add skill" class="btn w-100 text-center">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>