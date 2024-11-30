<?php
/* $logFile = fopen("c:\\Program Files (x86)\\EasyPHP-Devserver-17\\Error_logs\\php\\testError110524.log", "a"); */

function deleteRecord($recordNumber, &$row_count, &$error_array) {
  for ($J = $recordNumber; $J <= $row_count - 1; $J++) {
    if ($error_array[$J][0] !== '' && $error_array[$J][1] !== '' && $error_array[$J][2] !== '') {
      $error_array[$J] = $error_array[$J+1];
    } else {
      break;
    }
  }
  unset($error_array[count($error_array)-1]);
  $row_count--;
}

function saveChanges($row_count, $error_array, $log_filePath) {
  $log_file = fopen($log_filePath, "w");
  //deletes the file
  fclose($log_file);
  unset($log_file);
  //reopen the file to append new lines
  $log_file = fopen($log_filePath, "a");
  for ($I = 0; $I <= $row_count; $I++) {
    $writeString = $error_array[$I][0]." | ".$error_array[$I][1]." | ".$error_array[$I][2];
    fwrite($log_file, $writeString);
  }
  fclose($log_file);
}

function displayRecords($row_count, $error_array) {
  echo "<html><head>";
  echo "<style>
    table {
      border: 2px solid #5c744d; 
    }
  </style>";
  echo "</head><body><table>";
  echo "<tr><th>Delete</th><th>Date/Time</th><th>Error Type</th><th>Error Message</th></tr>";

  for ($J=$row_count;$J>=0;$J--) {
    echo "<tr><td><a href='excercise.php?rn=$J'>delete</td>";
    for ($I = 0;$I<=2;$I++) {
      echo "<td>".$error_array[$J][$I]."</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  echo "</body></html>";
}
//We can use define() to create a constant at runtime, is usefule to use variables (normal constant declaration does not allow using variables within its name)
define('ERROR_LOG_FILE_PATH', "c:\\Program Files (x86)\\EasyPHP-Devserver-17\\Error_logs\\php\\testError110524.log");


$log_file = fopen(ERROR_LOG_FILE_PATH, "r");
$row_count = 0;

while (!feof($log_file)) {
  $line = fgets($log_file);
//removes whitespaces and escape characters from the beginning and the end of a string, in the second parameter, we can also specify which characters we have to remove
  if ($line !== false && trim($line) !== '') {
    $data = explode(" | ", $line);
    if (count($data) === 3) {
      $error_array[$row_count] = $data;
      $row_count++;
    }
  }
}
$row_count--;
print_r($error_array)."<br>";
fclose($log_file);

if (isset($_GET['rn'])) {
  deleteRecord($_GET['rn'], $row_count, $error_array);
  saveChanges($row_count, $error_array, ERROR_LOG_FILE_PATH);
  unset($_GET['rn']);
}

displayRecords($row_count, $error_array);

?>