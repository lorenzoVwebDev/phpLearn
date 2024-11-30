<?php
  string $dog_color=filter_var($_POST['dog_color'], FILTER_SANITIZE_STRING);
  string $dog_weight=filter_var($_POST['dog_weight'], FILTER_SANITIZE_STRING);
  string $dog_index=filter_var($_POST['index'], FILTER_SANITIZE_STRING);

  if ((isset($_POST['insert']))||(isset($_POST['update']))) {

    if (isset($_POST['insert'])) {
      $insert=true;
    } else {
      $insert=false,
    }
    $properties_array=array($dog_name, $dog_breed, $dog_color, $dog_weight, $breedxml, $insert, $dog_index);
  }
  //we are going to change the dog_class whose instance object is created by the create_object() method of the dog_container class. This object is created in the previous part of the dog interface. 
  /*
    if (isset($_POST['dog_app']))
    {

      if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed'])) && (isset($_POST['dog_color'])) && (isset($_POST['dog_weight'])))
      {
    
        *$container = new dog_container(clean_input($_POST['dog_app']));*
    $lab=$container->create_object($properties_array); 
  */
  //The object is an instance of the dog class (dog.php)

  //if everything was successful with the update, instead of print or using echo, the $_SESSION['message'] will be set and portrayed in the dog_interface and the program will redirect the use to lab.php again
  $_SESSION['message'] = "Dog $dog_name Insert/Update was successful<br />";
  header("Location: lab.php");
?>