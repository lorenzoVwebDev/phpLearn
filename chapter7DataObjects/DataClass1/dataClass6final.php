<?php

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
      /*
       Using json instead of xml. 
       $json = file_get_contents($this->dog_data_JSON);
       $this->dogs_array = json_decode($json, true);
       //json_last_error() is a method that returns a constant, is used after json_decode() or json_encode(); if any error doesn't occur, it returns JSON_ERROR_NONE
       if ($this->dogs_array === null && json_last_error() !== JSON_ERROR_NONE) {
       //json_last_error_msg() returns the error string of the last json_encode() or json_decode() call
        throw new Exception("JSON error: ".json_last_error_msg());
       } 
      */
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


    function deleteRecord($recordNumber) {
      //we are going to use the renference & to modify dogs_value
      //$dogs is the key name of the associative array whereas $dogs_value is its content
      //
      foreach ($this->dogs_array as $dogs=>&$dogs_value) {
        for ($J=$recordNumber; $J < count($dogs_value) - 1; $J++) {
      //$column is the key name of the internal values (dog_name, dog_weight etc) whereas $column_value is its content
          foreach ($dogs_value[$J] as $column => $column_value) {
            $dogs_value[$J][$column] = $dogs_value[$J + 1][$column];
          } 
        }
      unset($dogs_value[count($dogs_value) - 1]);
      }
    }

    function readRecords($recordNumber) {
      if($recordNumber === "ALL") {
        return $this->dogs_array["dog"];
      } else {
        return $this->dogs_array["dog"][$recordNumber];
      }
    }

    function insertRecords($records_array) {
      $dogs_array_size = count($this->dogs_array["dog"]);
      //the for loop counts the number of the new records in the record array and add the new record until the condition is no more satisfied, The condition is also based on the number of records in the records_array
      for ($I=0;$I < count($records_array);$I++) {
        $this->dogs_array["dog"][$dogs_array_size 
         + $I] = $records_array[$I];
      }
    }
/*     records_array = Array (
      0 => Array ( "dog_name" => "Jeffrey", "dog_weight" => "19",
      "dog_color" => "Green", "dog_breed" => "Lab" ),
      2 => Array ( "dog_name" => "James", "dog_weight" => "21",
      "dog_color" => "Black", "dog_breed" => "Mixed" )); */

    function updateRecords ($records_array) {
      foreach ($records_array as $records => $record_value) {
          $this->dogs_array["dog"][$records] = $records_array[$records];
      }
    }
  }

  $dog_data_object = new dog_data();
?>