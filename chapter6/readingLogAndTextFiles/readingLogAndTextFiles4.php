<?php
$dogs = array (
  array("Sammy","Lab",18,"Yellow"),
  array("Spot","Mixed",14,"Mixed"),
  array("Princess","Chihuahua",4,"White"),
  array("Max","Boxer",35,"Brown")
);
//in PHP, we can display multi-dimensional arrays typing them in that way below, the firs index in the [] represent the value's index in the first array, the second represents the index of the child array
echo $dogs[0][0]; // displays Sammy
echo $dogs[0][3]; // displays Yellow
echo $dogs[3][0]; // displays Max
echo $dogs[3][3]; // displays Brown

$logFile = fopen("error_log.log", "r");
$row_Count = 0;
while (!feof($logFile)) {
  //explode creates an array that is put into the array $error_Array[$row_Count]
  print_r($error_Array[$row_Count] = explode(' | ', fgets($logFile)));
  //$row_Count++ enanche the index by one at each iteration
  $row_Count++;
}
?>