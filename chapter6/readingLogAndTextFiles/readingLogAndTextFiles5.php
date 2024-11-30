<?php
//Creating a table
$logFile = fopen("Errors.log", "r");
$row_Count = 0;
//<table> the opening table tag
echo "<table>";
while (!feof($logFile)) {
  //<tr> opening table's row tag
  echo "<tr>";
  $error_Array[$row_Count] = explode(' | ', fgets($logFile));
  $displayString = "";
    for ($I=0; $I < 3; $I++) {
      //<td> opening table cell tag
      echo "<td>".$error_Array[$row_Count][$I] . "</td>";
    }
  echo "</tr>";
  $row_Count++;
}
echo "</table>";
fclose($logFile);
?>