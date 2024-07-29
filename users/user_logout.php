<!-- USER LOGOUT SECTION -->

<?php 

// Start session
session_start();

// Unset all session variables
session_unset();

// Destroy all sessions
session_destroy();

// Redirect user to the home page
header("location: index.php?page=home");
exit;
?>