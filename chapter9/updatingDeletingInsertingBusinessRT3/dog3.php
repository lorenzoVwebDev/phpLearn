<?php
class Dog {
//we are now going to change the change_dog_data($type) used previously in dog1.php and dog2.php
private function change_dog_data($type) {
  if(file_exists("dog_container.php")) {
    require_once("dog_container.php");
  } else {
    throw new Exception("Dog container file missing or corrupt");
  }
  //it creates the a dog_data instance
  $container = new dog_container("dogdata");
  //it's not essential passing an array, we can even pass just a string saying "dogdata"
  $properties_array=array("dogdata");
  $dog_data=$container->create_object($properties_array);
  //these three lines retrive the dog_data last method, processRecords(); we can just retrive it by typing; $dog_data->processRecords()
  $method_array = get_class_methods($dog_data);
  $last_position = count($method_array) - 1;
  $method_name = $method_array[$last_position];
  //it runs the processRecords() method of dog_data; it then runs the respective method:
  /* function processRecords($change_Type, $records_array)
{

switch($change_Type)
{
    
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
		return $this->readRecords($records_array);
		break;
	default:
		throw new Exception("Invalid XML file change type: $change_Type");
}

}
} */
  if (($this->index>-1) && ($type == "Delete")) {
    $record_Array = $this->index;
    $dog_data->$method_name("Delete", $record_Array);
  }
  //it runs this else if when the type of process is an insert
  else if (($this->index == -1) && ($type == "Insert/Update")) {
    //we are going to create the $record_array to pass in the processRecords() method based of the the Dog instance properties
    $record_Array = array(array('dog_name'=>"$this->dog_name", 'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color", 'dog_breed'=>"$this->dog_breed"));
    $dog_data->$method_name("Insert",$record_Array);
  } 
  //it runs this else if when the type of the process is an Update
  else if ($type == "Insert/Update") {
        //we are going to create the $record_array to pass in the processRecords() method based of the the Dog instance properties as well as before, this is going to change the previous dog row with the new data
    $record_Array = array($this->index => array('dog_name'=>"$this->dog_name", 'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color",'dog_breed'=>"$this->dog_breed"));
    $dog_data->$method_name("Update",$record_Array);
  }
  //then we are going to declare $dog_data as NULL; this destructs the dog_data instance and so it runs the dog_data destructor that update(recreates) the dog data xml file or JSON or mySQL
  $dog_data = NULL;
  }


?>