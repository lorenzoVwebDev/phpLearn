<?php
  namespace MailerSystem;
  require '../vendor/autoload.php';



  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use LoggingDogErrors\Error_logging;


  function sendMail($date, $eMessage) {
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'lorenzoviganego1@gmail.com';
      $mail->Password = 'gpom nsmp myjc wiuz';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->setFrom('lorenzoviganego1@gmail.com');
      $users = array (
        'lorenzo.viganego@libero.it'
      );

      foreach($users as $user) {
        $mail->addAddress($user);
        $mail->isHTML(true);
        $mail->Subject = $date . "Fatal System error";
        $mail->Body = "$eMessage";
        $mail->send();

        echo "Mail to $user has been sent";

        $mail->clearAddresses();
      };
    } catch (Exception $t) {
      $logException = new Error_logging($t->getMessage(), 'Mailer Exception');
      $logException->logError();
      print "Server exception 500";
    } catch (Error $e) {
      $logException = new Error_logging($e->getMessage(), 'Mailer Error');
      $logException->logError();
      print "Server error 500";
    } catch (Throwable $t) {
      $logException = new Error_logging($e->getMessage(), 'Mailer Other Errors');
      $logException->logError();
      print "Server throwable 500";
    }
  }

?>