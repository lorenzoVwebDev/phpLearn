<?php
  //to improve the destructor we are going to use the mysqli() class whose methods are similar to the functions used in the constructor
  //new mysqli() creates a new instance of the mysqli class and attempts to connect to the MySQL database with the given parameters (the same previously required by the mysqli_connect())
  $mysqli = new mysqli($server, $ds_username, $db_password, $database);
  //connect_errno returns the error code from the last connection attempt
  if ($mysqli->connect_errno) {
  //connect_error returns a description of the connection error
    throw new Exception("MySQL connection error:".$mysqli->connect_error);
  }
//query("DROP TABLE IF EXISTS Dogs") remove any previous table named Dogs
//!$mysqli->query("CREATE TABLE IF NOT EXISTS.... creates the new Dog table with columns for each attribute (dog_id CHAR(4), dog_name CHAR(20) etc.)
if(
  (!$mysqli->query("DROP TABLE IF EXISTS Dogs") || 
  !$mysqli->query("CREATE TABLE IF NOT EXISTS Dogs (
    dog_id CHAR(4), 
    dog_name CHAR(20), 
    dog_weight(3), 
    dog_color CHAR(15), 
    dog_breed CHAR(35)")
  )
  ) {
//if any of the two queries fail, a error will be dropped
  throw new Exception("Dog table can't be created or deleted. Error: ".$mysqli->error);
}

      /*     
  Array ( [dog] => Array (
    [0] => Array ( [dog_name] => Woff [dog_weight] => 12
      [dog_color] => Yellow [dog_breed] => Lab )
    [1] => Array ( [dog_name] => Sam [dog_weight] => 10
      [dog_color] => Brown [dog_breed] => Lab )
    )) 
  */

foreach ($this->dogs_array as $dogs=>$dogs_array) {
  foreach ($dogs_array as $dog => $dog_value) {
    $dog_id = $dog_value["dog_id"];
    $dog_name = $dog_value["dog_name"];
    $dog_weight = $dog_value["dog_weight"];
    $dog_color = $dog_value["dog_color"];
    $dog_breed = $dog_value["dog_breed"];
    // the INSERT query is used to add a new record (or row) in the table
    if(!$mysqli->query("INSERT INTO 
    /* Dogs(dog_id, dog_name etc specifies which column will receive values */
    Dogs(dog_id, dog_name, dog_weight, dog_color, dog_breed)
/*     the VALUES clause that follows INSERT INTO contains the values that will be added to each respective column, is essential that the values follow the same order that columns have been sorted in before */
    VALUES ('$dog_id', '$dog_name', '$dog_weight', '$dog_color', '$dog_breed'")) {
      throw new Exception("Dog Table Insert Error: ".$mysqli->error);
    }
  }
}
?>