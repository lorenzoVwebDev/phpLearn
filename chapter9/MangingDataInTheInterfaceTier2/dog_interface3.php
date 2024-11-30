<?php
  if ((isset($_POST['insert']))||(isset($_POST['update']))) {

    if (isset($_POST['insert'])) {
      $insert=true;
    } else {
      $insert=false,
    } 

    $properties_array=array($dog_name, $dog_breed, $dog_color, $dog_weight, $breedxml, $insert, $dog_index);
  } else if ($_POST['delete']) {
    //if we have to delete, the processRecord method in dog_data requires just a string (the dog_index) to know which row it has to delete (the processRecord method redirects you to the deleteRecord method)
    $properties_array=$dog_index;
    //this will create the object as well as the previous one
    $lab= $container->create_object($properties_array);
    //it will set the session message as before
    $_SESSION['message'] = "Dog $dog_name Deletion was successful<br />";
    header("Location: lab.php");
  }
?>