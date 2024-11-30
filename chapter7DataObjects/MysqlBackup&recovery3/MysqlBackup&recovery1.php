<?php

  /*       
$records_array = array (
    array ( 
      "dog_name"=>"Jeffrey", 
      "dog_weight"=>"19",
      "dog_color"=>"Green", 
      "dog_breed"=>"Lab" 
    ), array ( 
      "dog_name"=> "James", 
      "dog_weight"=> "21",
      "dog_color"=> "Black", 
      "dog_breed"=> "Mixed" )
  );   */
  //We are now going to updated the log file for backups and recoveries by inserting in it Mysql strings to update the database
  //This code assumes that the Dogs table has been created with the fields in the order shown
  private function updateRecords ($records_array) {
    $change_string = "";
    foreach ($records_array as $records => $record_value) {
        $this->dogs_array["dog"][$records] = $records_array[$records];
        //all this query will be inserted in the log file
        $change_string .= "UPDATE Dogs";
        $change_string .= "SET dog_name='".$records_array[$records]['dog_name']."', ";
        $change_string .= "dog_weight='".$records_array[$records]['dog_weight']."', ";
        $change_string .= "dog_color='".$records_array[$records]['dog_color']."', ";
        $change_string .= "dog_breed='".$records_array[$records]['dog_breed']."', ";
        //the WHERE clause is required to determine which record(s) to update
        $change_string .= "WHERE dog_id='".$records_array[$records]['dog_id']."';\n";
    }
/*  $change_string = date('mdYhis') . " | Update | " . serialize($records_array) . "\n"; */
    $change_log_file = $this->change_log_path . date('mdYhis') . "change.log";
    error_log($change_string,3,$change_log_file); 
  }

  private function deleteRecord($recordNumber) {
    foreach ($this->dogs_array as $dogs=>$dogs_value) {
      for ($J=$recordNumber;$J<count($dogs_value)-1;$J++) {
        foreach($dogs_value[$J]as$column=>$column_value) {
          $dogs_value[$J][$column]=$dogs_value[$J+1][$column];
        }
      }
      unset($dogs_value[count($dogs_value)-1]);
    }
    $dog_id=$this->dogs_array['dog'][$recordNumber]['dog_id'];
    $change_string="DELETE FROM Dogs WHERE dog_id='".$dog_id."';\n";
    $change_log_file=date('mdYhis').$this->change_log_file;
    error_log($change_string,3,$change_log_file);//might exceed 120 chars
   }

   private function insertRecords($records_array) {
    string $change_string="";
    $dogs_array_size=count($this->dogs_array["dog"]);
    for($I=0;$I<count($records_array);$I++) {
      $this->dogs_array["dog"][$dogs_array_sie+$I]=$records_array[$I];
      $dog_id=rand(0,9999);//get a number between 0 and 9999 it is useful to create a new id for the record to insert
      //Check with a loop whether a dog_id exists yet, if it exists yet, make it generate a new id until it finds an unused one
      $change_string.="INSERT INTO Dogs VALUES('";
      $change_string.=$dog_id."', '".$records_array[$I]['dog_name']."', '";
      $change_string.=$records_array[$I]['dog_weight']."', '";
      $change_string.=$records_array[$I]['dog_color']."', '";
      $change_string.=$records_array[$I]['dog_breed']."', '";
    }
    $change_log_file=date('mdYhis').$this->change_log_file;
    error_log($change_string,3,$change_log_file);
   }

  /*    
  The change log (which is now also a SQL script file) would now contain statements
  similar to the following:
  INSERT INTO Dogs VALUES('2288', 'tester1', '19', 'Green', 'Lab');
  UPDATE Dogs SET dog_name='tester1', dog_weight='19', dog_color='Green',
  dog_breed='Lab' WHERE dog_id='0111';
  UPDATE Dogs SET dog_name='tester2', dog_weight='19', dog_color='Green',
  dog_breed='Lab' WHERE dog_id='1211';
  DELETE FROM Dogs WHERE dog_id='1111' 
  */



?>