<?php
//we are now extending the built in class Exception to create the errorMessage() method
class zeroException extends Exception {
  public function errorMessage() {
  $errorMessage = "Second Number cannot be " . $this->getMessage();
  return $errorMessage;
  }
  }
  try {
  if ($secondNumber == 0)
  { throw new zeroException("Zero"); }
  else
  { $result = $firstnumber / $secondnumber; }
  // other code with exceptions
  }
  //in the catch argument, we can specify to catch an exception of the zeroException class
  //remember to put the hierarchical inferior class in the catch block before the one with the superior class. In this case, zeroException() is an extension of the Exception class that is inferior compared to Throwable, which is the highest class in the errors/exceptions classes
  catch(zeroException $e) {
  echo $e->errorMessage();
  }
  catch(Throwable $t) {
  Echo $t->getMessage();
  }
?>