<?php declare(strict_types=1);
class Dog {
  //code in dog1.php
  // ------------------------------ Properties ------------------------------
  private int $dog_weight = 0;
  private string $dog_breed = "no breed";
  private string $dog_color = "no color";
  private string $dog_name = "no name";
  private string $error_message = "??";
  private string $breedxml = "";
  private bool $insert = FALSE;
  private $index = -1;
  // ----------------------------- Constructor ------------------------------
  function __construct($properties_array) {
    if (method_exists('dog_container', 'create_object')) {
      if (is_array($properties_array)) {
        $this->breedxml = $properties_array[4];
        $name_error = $this->set_dog_name($properties_array[0]) == TRUE ?
        'TRUE,' : 'FALSE,';
        $color_error = $this->set_dog_color($properties_array[2]) == TRUE ?
        'TRUE,' : 'FALSE,';
        $weight_error= $this->set_dog_weight($properties_array[3]) == TRUE ?
        'TRUE' : 'FALSE';
        $breed_error = $this->set_dog_breed($properties_array[1]) == TRUE ?
        'TRUE,' : 'FALSE,';
        $this->error_message = $name_error . $breed_error . $color_error .
        $weight_error;
        if(stristr($this->error_message, 'FALSE')) {
          throw new setException($this->error_message);
        }
        //code in dog2.php
        if((is_bool($properties_array[5])) && ($properties_array[6] > -1)) { 
          $this->insert = $properties_array[5];
          $this->index = $properties_array[6];
        }
        $this->change_dog_data("Insert/Update");
      }
      if(is_numeric($properties_array)) { 
        $this->index = $properties_array;
        $this->change_dog_data("Delete");
      }
    } else {
      exit;
    }
  }

  function set_dog_breed($value) {
    $error_message = TRUE;
    ($this->validator_breed($value) === TRUE)?$this->dog_breed=$value:$this->error_message = FALSE;
    return $this->error_message;
  }

  function set_dog_color($value) {
    $error_message = TRUE;
    (ctype_alpha($value)&&strlen($value)<=15)?$this->dog_color=$value:$this->error_message = FALSE;
    return $this->error_message; 
  }
  // ------------------------------ Get Methods ------------------------------
  function get_dog_name() : string {
    return $this->dog_name;
  }
  function get_dog_weight() : string {
    return $this->dog_weight;
  }
  function get_dog_breed() : string {
    return $this->dog_breed;
  }
  function get_dog_color() : string {
    return $this->dog_color;
  }
  function get_properties() : string {
    return "$this->dog_name,$this->dog_weight,$this->dog_breed,$this->dog_color.";
  }
  // ---------------------------General Methods-----------------------------
  private function validator_breed($value) : bool {
    $breed_file = simplexml_load_file($this->breedxml);
    $xmlText = $breed_file->asXML();
    if(stristr($xmlText, $value) === FALSE) {
      return FALSE;
    } else  { return TRUE;
    }
  }

  private function change_dog_data($type) {
    //code in dog3.php
    if ( file_exists("e8dog_container.php")) {
      require_once("e8dog_container.php");
    // use Chapter 5 container w exception handling
    } else {
      throw new Exception("Dog container file missing or corrupt");
    }
    // sets the tag name to look for in XML file
    $container = new dog_container("dogdata"); 
    $properties_array = array("dogdata");
    // not used but must be passed into create_object
    $dog_data = $container->create_object($properties_array);
    // creates dog_data object
    $method_array = get_class_methods($dog_data);
    $last_position = count($method_array) - 1;
    $method_name = $method_array[$last_position];
    if (($this->index > -1) && ($type == "Delete")) {
      $record_Array = $this->index;
      $dog_data->$method_name("Delete",$record_Array);
    } else if (($this->index == -1) && ($type == "Insert/Update")) {
      $record_Array = array(array('dog_name'=>"$this->dog_name",
      'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color", 'dog_breed'=>"$this->dog_breed"));
      $dog_data->$method_name("Insert",$record_Array);
    } else if ($type == "Insert/Update") {
      $record_Array = array($this->index => array('dog_name'=>"$this->dog_name",'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color",'dog_breed'=>"$this->dog_breed"));
      $dog_data->$method_name("Update",$record_Array);
    }
      $dog_data = NULL;
  }

  function display_dog_data($record) {
    if ( file_exists("e8dog_container.php")) {
      // use Chapter 5 container w exception handling
      require_once("e8dog_container.php"); 
    } else {
      throw new Exception("Dog container file missing or corrupt");
    }
    // sets the tag name to look for in XML file
    $container = new dog_container("dogdata"); 
    // not used but must be passed into create_object
    $properties_array = array("dogdata"); 
    $dog_data = $container->create_object($properties_array);
    // creates dog_data object
    $method_array = get_class_methods($dog_data);
    $last_position = count($method_array) - 1;
    $method_name = $method_array[$last_position];
    $record_Array = $record;
    return $dog_data->$method_name("Display",$record_Array);
  }
}
?>