<?php
//The log file can now be used to update the database. The destructor can now execute this file (instead of removing the table and inserting all the records back into a new table).
$mysqli = new mysqli($server,$db_usernam,$db_password,$databae);
if($mysqli->connect_errno) {
  throw new Exception("MySQL connection error:".$mysqli->connect_error);
}
$change_log_file=date('mdYhis').$this->change_log_file;
//explode divide the logs by the ; symbol and the it creates an array with each of the queries contained in the change_log_file
$sql=explode(";",file_get_contents($change_log_file));
//the queries will be applied one by one in the loop
foreach($sql as $query) {
  if(!$mysqli->query($query)) {
    throw new Exception("Dog Table Change Error: ".$mysqli->error);
  }
}
?>