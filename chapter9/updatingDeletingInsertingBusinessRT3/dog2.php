<?php
class Dog {
function __construct($properties_array) {
//there is the previous __construct code before it...
//this if statement below checks whethre $insert ($properties_array[5]) is a boolean or not and if the dog index($properties_array[6]) is equal or more that -1, it implies that the action is an Insert/Update
if ((is_bool($properties_array[5]))&&($properties_array[6]>=-1)) {
  $this->insert=$properties_array[5];
  $this->index=$properties_array[6];
}
//it then runs the change_dog_data("Insert/update)
$this->change_dog_data("Insert/Update");
}
//if it is a delete, $properties_array will just be just equeal to the $dog_index, as set in the dog_interface.php, so we are going to set the Dog instance $index property equal to it.
if (is_numeric($properties_array)) {
  $this->index = $properties_array;
  //we are going to run the change_dog_data("Delete") 
  $this->change_dog_data("Delete");
}
?>