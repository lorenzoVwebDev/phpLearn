<?php
function errorHandler($severity, $message, $file, $line) {
  //built it class that transform errores into exceptions
  throw new errorException($message, 0, (int)$severity, $file, $line);
}

class userException extends Exception {}

set_error_handler('errorHandler');
try {
  require_once('./testerror.php');
  $tester = new testerror();
/*   $tester->produceerror(); */
  $tester->throwException();
} catch (errorException $ee) {
  echo $ee->getLine()."<br>";
} catch (userException $ue) {
  echo $ue->getMessage()."<br>";
} catch (Throwable $t) {
  echo $t->getMessage()."<br>";
} finally {
  print "Finished";
}
?>