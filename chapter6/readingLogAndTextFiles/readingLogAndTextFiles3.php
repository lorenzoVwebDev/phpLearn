<?php
//the "r" second parameter means that the file should just be read
 $logFile = fopen("error_log.log", "r");
 //feof() checks whether the end of the file has been reached; if so, it returns true. Every time it is called it moves the pointer to the next line, so we can loop through it 
  while(!feof($logFile)) {
    //after fgets() is called, it creates a pointer that moves from the first line to the next and so on, this is the reason why we can loop through it
    echo fgets($logFile) ."<br>"
  }
  
 fclose($logfile);
?>