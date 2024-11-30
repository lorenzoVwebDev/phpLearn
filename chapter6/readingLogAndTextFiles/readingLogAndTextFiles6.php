<?php
//sorting the Errors.log line from the newer to the older
$logFile = fopen("Errors.log", "r");
$row_Count = 0;

while(!feof($logFile)) {
  $error_Array[$row_Count] = explode(' | ', fgets($logFile));
  $row_Count++;
}
//$row_Count is decremented because after the last iteration of the previous loop the index of the array is exceeding by one
$row_Count--;
fclose($logFile);
echo "<table>";
//By starting the for loop from the higher array's index, we are now showing the latest logs that are paired with the higher indexes
for ($J=$row_Count; $J >= 0; $J--) { 
  echo "<tr>";
  $displayString = "";

  for($I=0; $I <= 2; $I++) {
    echo "<td> " . $error_Array[$J][$I] . " </td> ";
  }
  echo "</tr>";
}

echo "</table>";
?>