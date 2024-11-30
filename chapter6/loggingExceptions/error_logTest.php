<?php
//the argument specify the log message
error_log("Lorenzo Viganego è il migliore");
const USER_ERROR_LOG = 'C:\\Program Files (x86)\\EasyPHP-Devserver-17\\eds-www\\chapter6\\LoggingExceptions\\User_Errors.log';
const ERROR_LOG = 'C:\\Program Files (x86)\\EasyPHP-Devserver-17\\eds-www\\chapter6\\LoggingExceptions\\Errors.log';
// sending a user error
// the firs argument is the log message, the second (digit) specifies the change of the default destination of the log file, the third is a constant that specifies the path
error_log("A user error", 3, USER_ERROR_LOG);
// sending all other errors
error_log("A user error", 3, ERROR_LOG);
?>