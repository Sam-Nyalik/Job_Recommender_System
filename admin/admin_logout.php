<!-- ADMIN LOGOUT SCRIPT -->

<?php
// Start session
session_start();

// Destroy session
$_SESSION = array();
session_destroy();

// Redirect admin to the login page
header("Location: index.php?page=admin/admin_login");
exit;

?>