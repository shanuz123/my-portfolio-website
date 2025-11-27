<?php
// Ensure the form was submitted before continuing
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Access Denied");
}

// ----------------------------------------------------
// !!! 1. CONFIGURE YOUR SETTINGS HERE !!!
// ----------------------------------------------------

// Your Target Gmail Address
$receiving_email_address = 'shanavasshafi07@gmail.com'; 

// Gmail Account used to SEND the email (it's best practice to use your own email)
$smtp_username = 'shanavasshafi07@gmail.com'; // e.g., mywebsite@gmail.com

// The App Password you generated in Step 1
$smtp_password = 'oeos vtfo dczw fcau'; // e.g., abcd efgh ijkl mnop

// ----------------------------------------------------

// Include the necessary PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Adjust the path below if your phpmailer folder is located elsewhere
require '../phpmailer/Exception.php'; 
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

// Sanitize the user input
$name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

// Construct the email body
$email_body = "You have received a new contact form submission:\n\n";
$email_body .= "Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Subject: " . $subject . "\n";
$email_body .= "Message:\n" . $message . "\n";


// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings for Gmail SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_username;
    $mail->Password   = $smtp_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
    $mail->Port       = 587; // Standard SMTP port for TLS
    $mail->CharSet    = 'UTF-8';

    // Recipients
    $mail->setFrom($smtp_username, 'Website Contact Form'); // Sender: Your Gmail account
    $mail->addAddress($receiving_email_address); // Recipient: shanavasshafi07@gmail.com
    $mail->addReplyTo($email, $name); // Set the user's email for easy reply

    // Content
    $mail->isHTML(false); // Set email format to non-HTML (plain text)
    $mail->Subject = $subject;
    $mail->Body    = $email_body;

    // Send the email
    $mail->send();

    // Success Message/Handling: This will be returned to the client-side code
    echo "OK"; 
    
} catch (Exception $e) {
    // Error Message/Handling
    // The "error-message" div in your form will display this if your client-side JS is set up.
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>