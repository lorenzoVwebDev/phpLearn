<?php
//php passes automatically the arguments below when the function is called(in this case, when an error occurs);severity: the error severity level int, message: the error message, file: the file where the error occured, $line: the line where the error occurred
function errorHandler($severity, $message, $file, $line) {
  //errorException: built in class that transform errors into exceptions brings the errorHandler's parameters as its constructor's parameters
  throw new errorException($message, 0, (int)$severity, $file, $line);
}

class userException extends Exception {}
  //set_error_handler redirects errors to be managed by this method
  set_error_handler('errorHandler');
  try {
    //it will be handled the error if the file testerror.php is missing, this error will be handled by the catch block with the Error type (missing file is an actual system error)
    require_once("testerror.php");
    $tester = new testerror();
    //$tester->produceerror() creates an exception that is gotten by the set_error_handler() which throws an errorException, it will be gotten by the errorException catch block that echoes $e->getMessage()
    $tester->produceerror();
    //code after produceerror() will not be displayed
    echo "This line does not display";
    $tester->throwexception();
    // will not execute if produceerror() is excuted
    echo "This line does not display";
  } catch (errorException $e) {
    echo $e->getMessage();
  } catch (userException $e) {
    echo $e->getMessage();
  } catch (Throwable $t) {
    echo "This line will display";
  }
  
  
/*   Program note—try/catch can also include a finally block after
  all catch blocks. The finally block will execute for all caught
  exceptions after the associated catch block has executed. PHP
  allows the finally block to exist without any catch blocks (but
  the try block must still exist). One of the most common uses of the
  finally block is to close files and/or databases when an exception
  has occurred. A program should not close before files and databases
  have been properly closed. If not closed properly, the data may
  become corrupt and not be accessible. */

  //exceptions don't shut down the program, so the code below will be executed
  echo "This line will display";
?>