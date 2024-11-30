<?php
//managing xml errors
  class dog_data {
    public $dogs_array = array();

    function __construct() {
      //enabling libxml library error handling
      libxml_use_internal_errors(true);
      $xmlfile = file_get_contents("dog.xml");
      //when $xmlfile is parsed in an object strucured in a good xml format by simplexml_load_string() it also return false in case the xml results not valid( that occurs mostly due to the xml file having been badly written)
      $xmlstring = simplexml_load_string($xmlfile);
      if ($xmlstring === false) {
        $errorString = "Failed loading XML: ";
        //libxml_get_errors() return an array of errors, is part of the the built in libxml library that is responsible for processing (managing) xml, methods like seimplexml_load_string() or DOMDocument::loadXML() are all part of the libxml library 
        foreach(libxml_get_errors() as $error) {
          $errorString .= $error->message . " ";
        }
        //then it throws an exception that will be catch by the catch blocks in the dog_interface script: errorStrin should not exceed 120 characters which is the maximum capacity of the log file. We can adjust this limit in the php configuration file
        throw new Exception($errorString);
      }
      $json = json_encode($xmlstring);
      $this->dogs_array = json_decode($json,TRUE);
    } 

    function __destruct() {
      $xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
      $xmlstring .= "\n<dogs>\n";

      foreach ($this->dogs_array as $dogs=>$dogs_value) {
        //$dog => $dog_value represents the associative array
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
  }

  $dog = new dog_data();


  unset($dog);
?>