<?php
  include("dataClass6final.php");
  $tester = new dog_data();
  $records_array = Array (
    0 => Array ( 
      "dog_name" => "Sally", 
      "dog_weight" => "19",
      "dog_color" => "Green", 
      "dog_breed" => "Lab" 
    )
  );

  $records_array = Array (
    1 => Array ( 
      "dog_name" => "Spot", 
      "dog_weight" => "19",
      "dog_color" => "Green", 
      "dog_breed" => "Lab" 
    )
  );

  $tester->updateRecords($records_array);
  print_r ($tester->readRecords("ALL"));
  print("<br>");

  $tester->deleteRecord(1);
  print_r($tester->readRecords("ALL"));
  //declaring an object as null instructs the system that the object should be removed from memory so that the destructor can run and save the new xml file with modfications.
  $tester = NULL;

  
?>