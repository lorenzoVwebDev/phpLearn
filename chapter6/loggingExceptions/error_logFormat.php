<?php
//You can find information on how to set the date() format on the php website documentation
$date= date('m.d.Y h:i:s');
$errorMessage = "This is the error";
$eMessage = $date."| User Error |". $errorMessage ."\n";
//with those modifications the constant includes the day date in the file name
//constant cannot accept dynamic values like date(); we have to use the define() to handle constans that require dynamic values
define('USER_ERROR_LOG', "C:\\Program Files (x86)\\EasyPHP-Devserver-17\\eds-www\\chapter6\\LoggingExceptions\\User_Errors". date('mdy') . ".log");
 error_log($eMessage, 3, USER_ERROR_LOG);
// Define the message without line breaks

?>