<?php
try {
  // code that might cause an exception
  // dividing by zero possible exception
  $result = $firstNumber / $secondNumber;
} catch (Throwable $t) {
  // PHP 7+ for catching all exceptions and errors, the Hierarchy is structured like that:
/*  Throwable
      ├── Exception
      └── Error */



  //getMessage() displays any system error related to the exception
/*   
Programming note—In addition to getMessage method, the
Exception and Error objects include
getCode()—Displays the code causing the exception
getFile()—Displays the file name containing code that threw the
exception
getLine()—Displays the line number that threw the exception
getTrace() and getTraceAsString()—Display backtrace
(exception flow through the program) information
In some circumstances, it might be appropriate to display the
Exception or Error message to the users. However, the other
methods should only be used for debugging or log entries. Providing
code information to the users is usually unnecessary and is a breach
of security. */
  $t->getMessage();
  //you can even use other things, such as language construct
  echo "You entered zero for the second number. "
} catch (Error $e) {
  // PHP 7+ capture and handle errors. 
} catch (Exception $e) {
  // code that will capture PHP 5+ exceptions.
  $e->getMessage();
}
?>