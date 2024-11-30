<?php
//fopen(file string, type_of_operation string) open the file or create it if it doesn't exist, the "a" second parameter indicates that anything should be appended to this file; "w" would indicate that the file should be rewritten entirely based on the new given content. We can put either an absolute path or a file name as its first argument
 $logFile = fopen("error_log.log", "a");
 $eMessage = $e->getMessage();
 //fwrite() write the message in the second argument "$Message"
 fwrite($logFile,$eMessage);
 //fclose() close the file
 fclose($logfile);
?>