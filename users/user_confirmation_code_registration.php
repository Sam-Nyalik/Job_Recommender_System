<!-- EMAIL CONFIRMATION CODE SECTION -->

<?php

// Start session
session_start();

// Include functions
include_once "functions/functions.php";
$pdo = databaseConnection();

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store the email session in a variable
    $email = $_SESSION["emailAddress"];

    // Generate a random 4 digit code
    $code = rand(1000, 9999);

    // Store code and email in the database
    $sql = "INSERT INTO email_confirmations(email_address, verification_code) VALUES(:emailAddress, :code)";
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":emailAddress", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":code", $param_verification_code, PDO::PARAM_INT);
        // Set parameters
        $param_email = $email;
        $param_verification_code = $code;
        // Attempt to execute
        if ($stmt->execute()) {
            // Send email
            $subject = "Your confirmation code";
            $message = "Hello, your confirmation code is: $code";
            $headers = "From: no-reply@nyalikjrs.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "<script>alert('Your verfication code has been sent successfully!')</script>";
                header("Location: index.php?page=users/user_email_confirmation");
            } else {
                echo "<script>alert('Verification code failed to be sent!')</script>";
                
            }
        }
    }
}


?>