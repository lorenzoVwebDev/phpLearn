<?php
try {
  if ($secondNumber == 0) {
    //throw an exception that is catch by catch (Exception $e) block. The string in the construct argument will be the getMessage() content. 
    throw new Exception("Zero Exception"); 
  } else { 
    $result = $firstnumber / $secondnumber; 
  }
  // other code with exceptions
  } catch(Exception $e) {
    switch ($e->getMessage()) {
      case "Zero Exception":
      echo "The value of second number must be greater
      than zero";
      break;
      default:
      echo "You did something else wrong";
      break;
    }
  } catch(Throwable $t) {
    echo $t->getMessage();
  }
?>