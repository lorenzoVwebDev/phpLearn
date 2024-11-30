<?php
  //once we have completed all the changes in the data array, we can return all the information to the storage location in the class destructor: the destructor is activated whenever the object is unset()
  class dog_data {
    public $dogs_array = array(); //we have to define an empty array
    
    function __construct() {
      $xmlfile = file_get_contents("dog.xml");
      $xmlstring = simplexml_load_string($xmlfile);
      $json = json_encode($xmlstring);
      $this->dogs_array = json_decode($json,TRUE);
    } 

    /*     
    Array ( [dog] =>
      Array (
      [0] => Array ( [dog_name] => Woff [dog_weight] => 12
      [dog_color] => Yellow [dog_breed] => Lab ),
      [1] => Array ( [dog_name] => Sam [dog_weight] => 10
      [dog_color] => Brown [dog_breed] => Lab )
      )
    ) */

    function __destruct() {
      $xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
      $xmlstring .= "\n<dogs>\n";
      //this code below, loops through the various leves of the $dog_array and create a xml file
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
      
      //it both creates a new file or replace an older one with the same name, the second argument is the new file's content
      file_put_contents("dog2.xml", $xmlstring);
    }
  }

  $dog = new dog_data();


  unset($dog);
?>