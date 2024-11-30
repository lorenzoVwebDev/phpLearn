<?php
function divideTwo(int|float $num1, int $num2) {

  $result = $num1 / $num2;

  print $result;

}

/* divideTwo(3, 4); */

try {
  include "./projects/addtwo.php";

  print divideTwo(2, 0) . "<br>";  
} catch(zeroException $e) {
  print "Don't try to divide by zero!";
} catch(Throwable $t) {

  print $t->getMessage() . "<br>";
} finally {
  print "Finish";
}
?>