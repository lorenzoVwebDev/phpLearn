<?php
  const LOG_DIRECTORY = "c://Program Files (x86)//EasyPHP-Devserver-17//Error_logs//php//";
  const XMLDATA_DIRECTORY = "c://Program Files (x86)//EasyPHP-Devserver-17//eds-www//chapter7DataObjects//MySQLandNoSQLdata2//";
function select_File_Process() {
  //glob() places all the files named as in the second parameter that are in a directory specified in the first parameter, into an array 
  $files = glob(LOG_DIRECTORY."*change.log");
  //the value and the name of the associative _POST array's value is <select>'s name and <option>'s value 
  echo "<form id='file_select' name='file_select' method='post' action='displayChangeLog.php'>";
  echo "<h3>Select a file to display</h3>";
  echo "<select name='change_file' id='change_file'>";
  foreach ($files as $file) {
    echo "<option value='$file'>$file</option>";
  }
  echo "</select>";
  echo "<input type='submit' id='submit' name='submit' value='select'>";
  echo "</form>";
}

//display process is called when a change file has been selected. this method calls the load_array method
function display_Process() {
  $change_array = load_array();
  $row_count = count($change_array)-1;
  displayRecords($row_count, $change_array, $_POST['change_file']);
}

//load_array() creates the change_array that contains all the logs in the file 
function load_array() {
  $change_file=$_POST['change_file'] ?? $_GET['change_file'];
  $change_array = [];
  if (file_exists($change_file)) {
    $logFile=fopen($change_file, "r");
  } else {
    throw new Exception('File not found');
  }
  $row_count=0;
  while(!feof($logFile)) {
    $line = fgets($logFile);
//trim() removes whitespaces and escape characters from the beginning and the end of a string, in the second parameter, we can also specify which characters we have to remove
    if ($line !== false && trim($line) !== '') {
      $data = explode(" | ", $line);
      if (count($data) === 3) {
        $change_array[$row_count] = $data;
        $row_count++;
      }
    }
  }
  $row_count--;
  fclose($logFile);
  return $change_array;
}

function displayRecords($row_count, $change_array, $change_file) {
  echo "<html><head>";
  echo "<style>
    table {
      border: 2px solid #5c744d; 
    }
  </style>";
  echo "</head><body>";
  echo "<table>";
  echo "<caption>Log File: " .$change_file. "</caption>";
  echo "<tr><th></th><th>Date/Time</th><th>Change Type</th><th>Change Data</th></tr>";
  for ($J=$row_count;$J>=0;$J--) {
    echo "<tr><td><a href='displayChangeLog.php?rn=$J&change_file=$change_file'>Delete</td>";
    for ($I=0;$I<=2;$I++) {
      echo "<td>".$change_array[$J][$I]."</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  echo "</body></html>";

  $files=glob(XMLDATA_DIRECTORY."*dog_data.xml");
  echo "<form id='file_select' name='file_select' method='post' action='displayChangeLog.php'>";
  echo "<h3>Delete entries above or select a file to update with change log $change_file</h3>";
  echo "<select name='data_file' id='change_file'>";
  foreach ($files as $file) {
    echo "<option value='$file'>$file</option>";
  }
  echo "</select>";
  echo "<input type='hidden' id='change_file' name='change_file' value='$change_file'>";
  echo "<input type='submit' id='submit' name='submit' value='select'>";
  echo "</form>";

/*   echo "<form id='data_select' name='data_select' method='post' action='readChangeLog.php>";
  echo "<h3>Delete entries above or select a file to update with change log $change_file</h3>";
  echo "<select name='data_file' id='data_file'>";
  foreach($files as $file) {
    echo "<option value='$file'>$file</option>";
  }
  echo "</select>";
  echo "<input type='hidden' id='change_file' name='change_file' value='$change_file'>";
  echo "<input type='submit' id='submit' name='submit' value='select'>";
  echo "</form>"; */
}

function delete_process() {
  $change_array = load_array();
  $row_count = count($change_array)-1;
  deleteRecord($_GET['rn'], $row_count, $change_array);
  saveChanges($row_count, $change_array, $_GET['change_file']);
  displayRecords($row_count, $change_array, $_GET['change_file']);
}

function deleteRecord($recordNumber, &$row_count, &$change_array) {
  for ($J=$recordNumber;$J<= $row_count-1; $J++) {
    if ($change_array[$J][0] !== '' && $change_array[$J][1] !== '' && $change_array[$J][2] !== '') {
      $change_array[$J] = $change_array[$J+1];
    } else {
      break;
    }
  }
  unset($change_array[count($change_array)-1]);
  $row_count--;
}

function saveChanges($row_count, $change_array, $change_file) {
  $changeFile = fopen($change_file, "w");
  fclose($changeFile);
  unset($changeFile);
  $changeFile = fopen($change_file, "a");
  for ($I = 0; $I <= $row_count; $I++) {
    $writeString = $change_array[$I][0]." | ".$change_array[$I][1]." | ".$change_array[$I][2];
    fwrite($changeFile, $writeString);
  }
  fclose($changeFile);
}

function update_XML_File_Process() {
  $change_array = load_array();
  require_once("dog_data.php");
  $data_changer = new dog_data();
  $row_count = count($change_array)-1;

  for ($I=0;$I<=$row_count-1;$I++) {
    
    if($change_array[$I][1] != "Delete") {
      $trimmedArray = trim($change_array[$I][2]);
      $temp = unserialize($trimmedArray); 
      if ($temp === false && $temp !== serialize(false)) {
        echo "Warning: Failed to unserialize data for index $I. Data: " . print_r($serialized_data, true) . "\n";
        continue;
    }
    } else {
      $temp = (integer)$change_array[$I][2];
    }
  }
  $data_changer->processRecords($change_array[$I][1], $temp);
  $data_changer->setChangeLogFile($_POST['data_file']);
  $dat_changer=null;
  echo "Changes completed";
  
}

if(isset($_POST['data_file'])&&isset($_POST['change_file'])) {
  update_XML_File_Process();
} else if(isset($_GET['rn'])&&isset($_GET['change_file'])) {
  delete_Process();
} else if(isset($_POST['change_file'])) {
  display_Process();
} else  {
  select_File_Process();
}
?>