<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPmailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lorenzoviganego1@gmail.com';
    $mail->Password = 'gpom nsmp myjc wiuz';
    $mail->SMTPSecure = PHPmailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('lorenzoviganego1@gmail.com', 'Lorenzo');
    $users = array (
        array (
            'lorenzo viganego 1',
            'lorenzo.viganego@libero.it'
        ), 
        array (
            'lorenzo viganego 2',
            'lorenzoviganego.work@libero.it'
        ),
        array (
            'lorenzo viganego 3',
            'gtauser@libero.it'
        )
    );

    foreach ($users as $user) {
        $mail->addAddress($user[1], $user[0]);

        $mail->IsHTML(true);
        $mail->Subject = 'Email Test';
        $mail->Body = "Hi". $user[0] . "this is a test";
        $mail->send();

        print "Email to ".$user[0]." has been sent"."<br>";

        $mail->clearAddresses();
    }

} catch (Exception $e) {
    print "An exception has occurred".$e->getMessage();
}
?>