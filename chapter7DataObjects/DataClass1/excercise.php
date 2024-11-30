<?php
  class dog_data {
    private $dogs_array = array();
    private $dog_data_xml = "";
    
    function __construct() {
      libxml_use_internal_errors(true);
      $xmlDoc = new DOMDocument();
      if(file_exists('dog_applications.xml')){
        $xmlDoc->load('dog_applications.xml');
        $searchNode=$xmlDoc->getElementsByTagName("type");
        foreach($searchNode as $searchNode){
          $valueID=$searchNode->getAttribute('ID');
          if($valueID=="datastorage"){
            $xmlLocation=$searchNode->getElementsByTagName("location");
            $this->dog_data_xml=$xmlLocation->item(0)->nodeValue;
            print $this->dog_data_xml;
            break;
          }
        }
      } else {
        $errorString="File not found:"."<br>";
        foreach(libxml_get_errors()as $error) {
          $errorString.=$error."<br>";
        }
        throw new Exception($errorString);
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
      $xmlfile = file_get_contents($this->dog_data_xml);
      $xmlObject = simplexml_load_string($xmlfile);
      if (!$xmlObject) {
        $errorString = "Bad xml format:"."<br/>";
        foreach(libxml_get_errors() as $error) {
          $errorString .= $error->message."<br/>";
        }
        throw new Exception($errorString);
      }
      $json = json_encode($xmlObject);
      $this->dogs_array = json_decode($json, true);
    }

    function __destruct() {
      $xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
      $xmlstring .= "\n<dogs>\n";
      
      foreach($this->dogs_array as $dogTagKey => $dogTagValue) {
        foreach($dogTagValue as $dogIndex => $dogArrays) {
          $xmlstring .= "<$dogTagKey>\n";
          foreach($dogArrays as $dogPropertiesKey => $dogPropertiesValues) {
            $xmlstring .= "<$dogPropertiesKey>"."$dogPropertiesValues" . "</$dogPropertiesKey>\n";
          }
          $xmlstring .= "</$dogTagKey>\n";
        } 
      }

      $xmlstring .= "</dogs>";
      file_put_contents('dog_8.xml', $xmlstring);
    }
    /*
    Array ( [dog] => Array (
      [0] => Array ( [dog_name] => Woff [dog_weight] => 12
        [dog_color] => Yellow [dog_breed] => Lab )
      [1] => Array ( [dog_name] => Sam [dog_weight] => 10
        [dog_color] => Brown [dog_breed] => Lab )
      )) 
    */

    function deleteRecord($recordNumber){

      foreach($this->dogs_array as $dogKey=>&$dogs_array) {
        foreach($dogs_array as $dogIndex=>$dogValue) {
          $dogs_array[$recordNumber]=$dogs_array[$recordNumber+1];
        }
      }
        unset($dogTagsArray[count($dogTagsArray)-1]);
      }

    function readRecords($recordNumber) {
      if($recordNumber === 'ALL') {
        return $this->dogs_array['dog'];
      } else {
        return $this->dogs_array['dog'][$recordNumber];
      }
    }

    function insertRecords($records_array) {
      $dogs_array_size=count($this->dogs_array);
      for($I=0;$I<count($records_array);$I++){
        $this->dogs_array['dog'][$dogs_array_size+$I]=$records_array[$I];
      }
    }

    function updateRecords($records_array) {
      foreach($records_array as $recordIndex=>$recordValue) {
        $this->dogs_array['dog'][$recordIndex]=$records_array[$recordIndex];
      }
      print_r($this->dogs_array);
    }
  }

  $records_array = Array (
    0 => Array ( "dog_name" => "Jeffrey", "dog_weight" => "19",
    "dog_color" => "Green", "dog_breed" => "Lab" ),
    2 => Array ( "dog_name" => "James", "dog_weight" => "21",
    "dog_color" => "Black", "dog_breed" => "Mixed" ));

  try {
    $test = new dog_data();
    print_r($test->updateRecords($records_array));
  } catch (Exception $e) {
    print $e->getMessage();
  } finally {
    $test = NULL;
  }

?>