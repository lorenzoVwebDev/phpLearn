<?php
//implementing the destructor to create new backup file once it rewrites the data file as well as using the setChangeLogFile() to choose what backup data file we should use instead of the current one if needed.
class dog_data {
      /*     
  Array ( [dog] => Array (
    [0] => Array ( [dog_name] => Woff [dog_weight] => 12
      [dog_color] => Yellow [dog_breed] => Lab )
    [1] => Array ( [dog_name] => Sam [dog_weight] => 10
      [dog_color] => Brown [dog_breed] => Lab )
    )) 
  */
  private $dogs_array = array();
  private $dog_data_xml = "";
  private $change_log_path = "C:\\Program Files (x86)\\EasyPHP-Devserver-17\\Error_logs\\php\\" ;

  function __construct() {
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    if (file_exists("dog_applications.xml")) {
      $xmlDoc->load('dog_applications.xml');
      $searchNode = $xmlDoc->getElementsByTagName("type");

        foreach($searchNode as $seachKey=>$searchNode) {
          $valueID = $searchNode->getAttribute('ID');
          if($valueID == "datastorage") {
            $xmlLocation = $searchNode->getElementsByTagName("location");
            $this->dog_data_xml = $xmlLocation->item(0)->nodeValue;
            break;
          }
        }
    } else {
      throw new Exception("Dog applications xml file missing or corrupt");
    }
    $xmlfile = file_get_contents($this->dog_data_xml);
    $xmlstring = simplexml_load_string($xmlfile);
    if ($xmlstring === false) {
      $errorString = "Failed loading XML: ";

      foreach(libxml_get_errors() as $error) {
        $errorString .= $error->message . " ";
      }

      throw new Exception($errorString);
    }
    $json = json_encode($xmlstring);
    $this->dogs_array = json_decode($json,TRUE);
  } 

  function __destruct() {
    $xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
    $xmlstring .= "\n<dogs>\n";

    foreach ($this->dogs_array as $dogs=>$dogs_value) {
      foreach ($dogs_value as $dog => $dog_value) {

        $xmlstring .="<$dogs>\n";
        foreach ($dog_value as $column => $column_value) {

          $xmlstring .= "<$column>" . $dog_value[$column] . "</$column>\n";
        }
      $xmlstring .= "</$dogs>\n";
      }
    }

    $xmlstring .= "</dogs>\n";
    //Here we are going to create both a backup of the old dog_data.xml  and the new dog_data.xml file
    //preg_replace() removes what it is specified in the first argument, the second argument specifies what the first argument must replaced with, the third argument is the value
    //Here we have removed all from the url except dog_data.xml; we have used regex
    $new_valid_data_file = preg_replace('/.*(?=dog_data\.xml$)/', '', $this->dog_data_xml);
    // date() is added to the old xml file's name
    $oldxmldata = date('mdYhis') . $new_valid_data_file;
    print  $new_valid_data_file;

    //rename() rename a file (in the first argument), with another name (in the second argument), both arguments work better with absolute paths
    if (!rename("$this->dog_data_xml", "C://Program Files (x86)//EasyPHP-Devserver-17//eds-www//chapter7DataObjects//MySQLandNoSQLdata2//$oldxmldata")) {
      throw new Exception("Backup file $oldxmldata could not be created.");
    };

    if (!file_put_contents("C://Program Files (x86)//EasyPHP-Devserver-17//eds-www//chapter7DataObjects//MySQLandNoSQLdata2//$new_valid_data_file", $xmlstring)) {
      throw new Exception("Can't create new file");
    };
  }

  //this method is used to specify previous backup files instead of the current one
  function setChangeLogFile($value) {
    $this->dog_data_xml = $value;
  }
  
  private function deleteRecord($recordNumber) {

    foreach ($this->dogs_array as $dogs=>&$dogs_value) {
      for ($J=$recordNumber; $J < count($dogs_value) - 1; $J++) {
        foreach ($dogs_value[$J] as $column => $column_value) {
          $dogs_value[$J][$column] = $dogs_value[$J + 1][$column];
        } 
      }
    unset($dogs_value[count($dogs_value) - 1]);
    }
    //we are now going to create logs for each change, $change_string creates the string to be logged in the log file
    $change_string = date('mdYhis') . " | Delete | " . $recordNumber . "\n";
    //$change_log_file takes the path ($this->change_log_path) and add the date and the change.log name to the file
    //use this date format date('Y-m-d_H-i-s') because windows does not allow to use : it its files' names
    $change_log_file = $this->change_log_path . date('mdYhis') . "change.log";
    //then error_log() both append to or creates the file where the log string must be placed
    error_log($change_string,3,$change_log_file); 
  }

  private function readRecords($recordNumber) {
    if($recordNumber === "ALL") {
      return $this->dogs_array["dog"];
    } else {
      return $this->dogs_array["dog"][$recordNumber];
    }
  }

  private function insertRecords($records_array) {
    $dogs_array_size = count($this->dogs_array["dog"]);
    for ($I=0;$I < count($records_array);$I++) {
      $this->dogs_array["dog"][$dogs_array_size+$I] = $records_array[$I];
    }
    //serialize() transforms an array to a string format similar to that below:
/*       a:1:{i:0;a:4:{s:8:"dog_name";s:7:"Spot";s:10:"dog_weight";s:2:"19";s:9:
        "dog_color";s:5:"Green";s:9:"dog_breed";s:3:"Lab";}} */
    //thus the data in the serialized string can be transformed in an array again using the unserialize() method
    $change_string = date('mdYhis') . " | Insert | " . serialize($records_array)."\n";
    $change_log_file = $this->change_log_path . date('mdYhis') . "change.log";
    error_log($change_string,3,$change_log_file); 
  }

  private function updateRecords ($records_array) {
    foreach ($records_array as $records => $record_value) {
        $this->dogs_array["dog"][$records] = $records_array[$records];
    }
    $change_string = date('mdYhis') . " | Update | " . serialize($records_array) . "\n";
    $change_log_file = $this->change_log_path . date('mdYhis') . "change.log";
    error_log($change_string,3,$change_log_file); 
  }

  function processRecords(string $change_type, $records_array) {
    switch ($change_type) {
      case "Delete":
        $this->deleteRecord($records_array);
        break;
      case "Insert":
        $this->insertRecords($records_array);
        break;
      case "Update":
        $this->updateRecords($records_array);
        break;
      case "Display":
        $this->readRecords($records_array);
        break;
      default:
        throw new Exception("Invalid XML file change type: $change_type");
    }
  }
}

// might exceed 120 chars
?>
