<?php
// Include Composer's autoload file
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Set up SMTP server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify the SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'lorenzoviganego1@gmail.com'; // Your Gmail address
    $mail->Password = 'gpom nsmp myjc wiuz'; // Use the generated app password here
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS (transfer socket layer) encryption: a cryptographic protocol designed to proved secure communication over a computer network;
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('lorenzoviganego1@gmail.com', 'Lorenzo'); // Your name and email
    $users = array (
        'lorenzo.viganeog@libero.it',
        'gtauser@libero.it',
        'lorenzoviganego.work@libero.it',
        'mariannameloni27@gmail.com'
    );
    foreach($users as $user){
        $mail->addAddress($user); // Add a recipient


        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Email Test'; // Email subject
        $mail->Body    = "Hi $user this is a test!"; // Email body content
    
        // Send the email
        $mail->send();
        echo "Email to $user has been sent successfully"."<br>"; // Success message
        $mail->clearAddresses();
    }

} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Error message
}
?>
