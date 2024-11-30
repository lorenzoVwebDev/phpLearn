<?php
class testerror {
  function produceerror() {
    //trigger_error() throws errors
    trigger_error("User Error", E_USER_ERROR);
    echo "This line will not display";
  }

  function throwException() {
    //it extends the Exception class; this line below throws exceptions
    throw new userException("User Exception");
    echo "This line will not display";
  }
}
?>