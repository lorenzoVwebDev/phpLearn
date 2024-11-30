<?php
//using references in the function's parameters "&", we can now modify both the row_Count and the error_Array, PHP doesn't allow to change values directly when they are encapsulated in a function
function deleteRecord($recordNumber, &$row_Count, &$error_Array) {
  //this loop  both deletes the row and fixes the positions: For example, if an array has ten positions (0–9) and the fifth position (4) has to be deleted, then positions 5–9 must now become positions 4–8.
  for ($J=$recordNumber; $J < $row_Count - 1; $J++) {
    for($I=0; $I < 3; $I++) { 
      $error_Array[$J][$I] = $error_Array[$J + 1][$I]; 
    }
  }
  //unset() deletes the last child array (row) because it is now an empty row (so, an empty array)
  unset($error_Array[$row_Count]);
  $row_Count--;
}

function saveChanges($row_Count,$error_Array,$log_File) {
  //this function rewrite the entire log file, the "w" in the second parameter of fopen() means so
  $logFile = fopen($log_File, "a");
  for($I=0; $I < $row_Count; $I++) {
    $writeString = $error_Array[$I][0] . " | " . $error_Array[$I][1] . " | " .
    $error_Array[$I][2];
    fwrite($logFile, $writeString);
  }

  fclose($logFile);
}

function displayRecords($row_Count, $error_Array) {
  echo "<html><head>";
  echo "<style> table { border: 2px solid #5c744d;} </style>";
  echo "</head><body><table>";
  echo "<caption>Log File: " . ERROR_LOG . "</caption>";
  //<th> tag defines a header table cell
  echo "<tr><th>Date/Time</th><th>Error Type</th><th>Error Message</
  th></tr>";
    for ($J=$row_Count; $J >= 0; $J--) {
      echo "<tr><td><a href='readingLogAndTextFiles7.php?rn=$J'>Delete</a></td>";
        for($I=0; $I < 3; $I++) {
          echo "<td> " . $error_Array[$J][$I] . " </td> ";
        }
      echo "</tr>";
    }

  echo "</table>";
  echo "</body></html>";
} // main section

const ERROR_LOG = "Errors.log";
$logFile = fopen(ERROR_LOG, "r");
$row_Count = 0;

while(!feof($logFile)) {
  $error_Array[$row_Count] = explode(' | ', fgets($logFile));
  $row_Count++;
}
$row_Count--;

fclose($logFile);

if(isset($_GET['rn'])) {
  deleteRecord($_GET['rn'], $row_Count, $error_Array);
  saveChanges($row_Count,$error_Array,ERROR_LOG);
}

displayRecords($row_Count,$error_Array);
?>