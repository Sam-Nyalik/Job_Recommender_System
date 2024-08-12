<!-- DECLINE JOB APPLICATION -->

<?php

// Start session
session_start();

// Check if the admin is loggedIn
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Fetch jobApplicationId from the url
$application_id = false;
if (isset($_GET['applicationId'])) {
    $application_id = $_GET['applicationId'];
}

// Prepare an UPDATE statement
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "UPDATE job_applications SET application_status = 2 WHERE jobApplicationId = $application_id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        header("location:index.php?page=admin/admin_dashboard");
    }
}

?>