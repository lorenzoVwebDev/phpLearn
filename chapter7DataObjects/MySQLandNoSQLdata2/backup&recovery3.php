<?php
//Backup and recovery, we are going to handle backup and recovery by creating the processRecords() that interprets any data passed into the class
class dog_data {
      /*     
  Array ( [dog] => Array (
    [0] => Array ( [dog_name] => Woff [dog_weight] => 12
      [dog_color] => Yellow [dog_breed] => Lab )
    [1] => Array ( [dog_name] => Sam [dog_weight] => 10
      [dog_color] => Brown [dog_breed] => Lab )
    )) 
  */
  public $dogs_array = array();
  public $dog_data_xml = "";

  function __construct() {
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    if (file_exists("e5dog_applications.xml")) {
      $xmlDoc->load('e5dog_applications.xml');
      $searchNode = $xmlDoc->getElementsByTagName("type");
        foreach($searchNode as $searchNode) {
          $valueID = $searchNode->getAttribute('ID');
          if($valueID == "datastorage") {
            $xmlLocation = $searchNode->getElementsByTagName("location");
            $this->dog_data_xml = $xmlLocation->item(0)->nodeValue;
            break;
          }
        }
        print $this->dog_data_xml;
    } else {
      throw new Exception("Dog applications xml file missing or corrupt");
    }

    $xmlfile = file_get_contents($this->$dog_data_xml);
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
    
    file_put_contents("dog2.xml", $xmlstring);
  }

  //we have set all the managing records private so that the code is now more secure, changes to the dog_array can be made only using the processRecords()  
  private function deleteRecord($recordNumber) {

    foreach ($this->dogs_array as $dogs=>&$dogs_value) {
      for ($J=$recordNumber; $J < count($dogs_value) - 1; $J++) {
        foreach ($dogs_value[$J] as $column => $column_value) {
          $dogs_value[$J][$column] = $dogs_value[$J + 1][$column];
        } 
      }
    unset($dogs_value[count($dogs_value) - 1]);
    }
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
      $this->dogs_array["dog"][$dogs_array_size 
       + $I] = $records_array[$I];
    }
  }

  private function updateRecords ($records_array) {
    foreach ($records_array as $records => $record_value) {
        $this->dogs_array["dog"][$records] = $records_array[$records];
    }
  }
  //this method allows the recovery program to pass all the modifier methods (updaterecords() insertRecords() etc.) into one method
  //this allows polymorphism which another essential concept i object oriented programming
  //In a work environment, it would be better to use a codes instead of actual instructions, such as "Delete" or"Insert" as the $change_type parameter. we can pass codes instead Example,     
/*   switch ($change_Type) {
      case "101":
        $this->deleteRecord($records_array);
        break;
      case "102":
        $this->insertRecords($records_array); */
  function processRecords(string $change_type, $records_array) {
    switch ($change_Type) {
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

$dog_data_object = new dog_data();
?>
