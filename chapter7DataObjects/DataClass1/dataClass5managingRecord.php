<?php
//delete, read, insert, update methods to manage the data array
  class dog_data {
    public $dogs_array = array();

    function __construct() {
      $xmlfile = file_get_contents("dog.xml");

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
    /*     
    Array ( [dog] => Array (
      [0] => Array ( [dog_name] => Woff [dog_weight] => 12
        [dog_color] => Yellow [dog_breed] => Lab )
      [1] => Array ( [dog_name] => Sam [dog_weight] => 10
        [dog_color] => Brown [dog_breed] => Lab )
      )) 
    */

    //this deleteRecordMethod deletes one of the two dog tag in the xml file, namely one of the two indexes of the [dog] array within the main dogs_array
    function deleteRecord($recordNumber) {
      //we are going to use the reference & to modify dogs_value
      //$dogs is the key name of the associative array whereas $dogs_value is its content
      //
      foreach ($this->dogs_array as $dogs=>&$dogs_value) {
        for ($J=$recordNumber; $J < count($dogs_value) - 1; $J++) {
      //$column is the key name of the internal values (dog_name, dog_weight etc) whereas $column_value is its content
          foreach ($dogs_value[$J] as $column => $column_value) {
            $dogs_value[$J][$column] = $dogs_value[$J + 1][$column];
          } 
        }
      unset($dogs_value[count($dogs_value - 1)]);
      }
    }

    //the readRecords method returns both the whole array within the main dogs_array or the just the array's index that we have selected. The formatting and displaying part are leaved to the interface tier 
    function readRecords($recordNumber) {
      if($recordNumber === "ALL") {
        return $this->dogs_array["dog"];
      } else {
        return $this->dogs_array["dog"][$recordNumber];
      }
    }

    //the insertRecords() method pass an array that contains all the new records that we want to add
    function insertRecords($records_array) {
      //dogs_array_size is not reduced by one because is used to directly represent a further value in the for loop to allow the first $record_array's value to be put into it without affecting the dogs_array_size last value
      $dogs_array_size = count($this->dogs_array["dog"]);
      //the for loop counts the number of the new records in the record array and add the new record until the condition is no more satisfied, The condition is also based on the number of records in the records_array
      for ($I=0;$I < count($records_array);$I++) {
        //$dogs_array_size is not reduced by one because $I is 0 during the first iteration
        $this->dogs_array["dog"][$dogs_array_size 
         + $I] = $records_array[$I];
      }
    }
/*       
$records_array = array (
    array ( 
      "dog_name"=>"Jeffrey", 
      "dog_weight"=>"19",
      "dog_color"=>"Green", 
      "dog_breed"=>"Lab" 
    ), array ( 
      "dog_name"=> "James", 
      "dog_weight"=> "21",
      "dog_color"=> "Black", 
      "dog_breed"=> "Mixed" )
  );   */

    //the updateRecords() exploits the fact that a dynamically built array can skip indexes, it uses numbers instead of strings as keys of associative arrays
/*     $records_array = Array (
      [0] => Array ( "dog_name" => "Jeffrey", "dog_weight" => "19",
      "dog_color" => "Green", "dog_breed" => "Lab" ),
      [2] => Array ( "dog_name" => "James", "dog_weight" => "21",
      "dog_color" => "Black", "dog_breed" => "Mixed" ));
      Dynamically built arrays are not required to have values for every position in the
      array. If the dynamic array shown previously is passed into the updateRecords method,
      records 0 and 2 would be updated with the new information. The value in position 1 in
      the dogs array would remain untouched. */
    function updateRecords ($records_array) {
      foreach ($records_array as $records => $record_value) {
          $this->dogs_array["dog"][$records] = $records_array[$records];
      }
    }
    //NOTE IMPORTANT:
  }

  $dog_object = new dog_data();

  $dog_array = $dog_object->dogs_array;
  $test_array = array (
    'lorenzo',
    'viganego',
    array (
      'simona',
      'amato'
    )
  );

  foreach($test_array as $indexes=>$values) {
    print print_r($values[1])."<br>";
  };
/*   print_r($test_array); */

?>