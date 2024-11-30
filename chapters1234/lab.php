<?php 
/*   declare(strict_types=1) */
  include_once "./dog.php";

  $lab = new Dog();
  //Set properties
  $dog_error_message = $lab->set_dog_name('Fred');
  print $dog_error_message ? "Name update successful <br>" : "Name update not successful <br>";

/*   bool $training_bool = true; */
  //Get properties
  $dogProperties = $lab->get_properties();

  //explode(string, string): divide a string into an array of values using as a separator the first argument
  //list(); creates variables based on a given array
  
  list($weight, $color, $name) = explode(',', $dogProperties);

  print $weight
?>