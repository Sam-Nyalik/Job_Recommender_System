<!-- DELETE COUNTY SECTION -->

<?php 

// Start session
session_start();

// Check if admin is loggedIn
if (!isset($_SESSION["admin_loggedIn"]) && $_SESSION["admin_loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=admin/admin_login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Check if county_id is set in the url
$county_id = false;
if(isset($_GET["county_id"])){
    $county_id = $_GET["county_id"];
}

// Delete county script
$sql = "DELETE FROM counties WHERE id = :countyId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":countyId", $param_countyId, PDO::PARAM_INT);
$param_countyId = $county_id;
if($stmt->execute()){
    header("location: index.php?page=admin/counties/all_counties");
    exit;
}

?>
