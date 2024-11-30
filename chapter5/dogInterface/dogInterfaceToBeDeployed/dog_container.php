<?php
  class Dog_container {
    private $app;
    private $dog_location;

    function __construct($value) {
      if (function_exists('get_properties')) {
        $this->app = $value;
      } else {
        //the 'exit' statement stops a script; it is identical to the 'die' statement
        exit;
      }
    }

    public function set_app($value) {
      $this->app = $value;
    }

    public function get_dog_application() {
      //xmlDoc->load('') load the xml file into the xmlDoc variable
      $xmlDoc = new DOMDocument();
      if (file_exists("dog_applications.xml")) {
        $xmlDoc->load('dog_applications.xml');
        //$xmlDOc->getElementsByTagName(""); searchs for all the occurrences with this tag in the file and returns all of them into an object
        $searchNode = $xmlDoc->getElementsByTagName("type");

        foreach($searchNode as $searchNode) {
          //it stores the IDs' values into the $valueID
          $valueID = $searchNode->getAttribute('ID');
          if($valueID == $this->app) {
            print 'true <br>';
            $xmlLocation = 
            $searchNode->getElementsByTagName("location");
            //$xmlLocation is now an object, with the item(0) method of DOMDocument we can select the first item of the object (in this case the object is made of just one item) and nodeValue is the item's value
            $file = $xmlLocation->item(0)->nodeValue;
            return $file;
            break;
          }
        }
      }
      return FALSE;
    }

    function create_object($properties_array) {
      $dog_loc = $this->get_dog_application();
      print $dog_loc . "<br>";
      if(($dog_loc == FALSE) || (!file_exists($dog_loc))) {
        print 'error <br>';
        return FALSE;
      } else {
        require_once($dog_loc);
        //get_declared_classes() returns an array of all currently declared class names in the script
        $class_array = get_declared_classes();
        //the class in the $dog_loc file is now the last array's item
          $last_position = count($class_array) -1;
          $class_name = $class_array[$last_position];
          print $class_name;
          $dog_object = new $class_name($properties_array);
          return $dog_object;
      }
    }
  }
?>