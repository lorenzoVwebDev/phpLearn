<?php
//the "r" second parameter means that the file should just be read
 $logFile = fopen("error_log.log", "r");
//fgets() read the first line in the file, then moves the pointer to the next line, so the next time it is called, it returns the next line.
  echo fgets($logFile);
 fclose($logfile);
?>