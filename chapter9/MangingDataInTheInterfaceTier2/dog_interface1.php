<?php
/*   The dog_interface program should accept the dogs array information from
  the data tier and, if needed, format it for use in the lab.php program. It should also
  accept the dogs information for the dogs list box, provide any format for it, and send it to
  lab.php for display. In addition, dog_interface must accept requests from lab.php for
  insert, update, and delete of dog information and pass these requests on to the data tier
  for processing. */
  string $dog_color=filter_var($_POST['dog_color'], FILTER_SANITIZE_STRING);
  string $dog_weight=filter_var($_POST['dog_weight'], FILTER_SANITIZE_STRING);
  //we have created the dog_index value, as the previous ones, we have to clean it in order to avoid any markup injection that could lead to highjack the business rules tier
/*   <!-- this input type gives an index to the dog, this property will be changed when the user selects a dog -->
  <input type="hidden" name="index" id="index"
  value= "-1"/> */
  string $dog_index=filter_var($_POST['index'], FILTER_SANITIZE_STRING);
  //the insert and updated processes are very similar
  if ((isset($_POST['insert']))||(isset($_POST['update']))) {

    if (isset($_POST['insert'])) {
      //    //we need a way to distinguish the two processes though. We use the $insert boolean to do so
      $insert=true;
    } else {
      $insert=false,
    }

      //an insert processes implies a new dog, a new dog correspond to a default index input value of -1 (if we want to modify a dog that is already in the dog data, the index input value will be modified based on the code that you can find in labHtmlScript4.php)

  //the properties_array now looks like that, it will contain both the $insert boolean and the $dog_index (we can use even just the $dog_index to distinguish an insert from an update)
    $properties_array=array($dog_name, $dog_breed, $dog_color, $dog_weight, $breedxml, $insert, $dog_index);
  }
  
?>