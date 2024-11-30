<?php
//constructor
$con=mysqli_connect($server, $db_user, $db_password, $dbdatabase);

if(mysqli_errno()) {
  throw new Exception("Mysql connection error: ".mysqli_error());
}

$sql="SELECT * FROM Dogs";
$result=mysqli_query($con, $sql);

if($result === null) {
  throw new Exception("No records retrieved from Database");
}

$this->dogs_array=mysqli_fetch_assoc($result);
mysqli_free_resul($result);
mysqli_close($con);

//destructor

$mysqli = new mysqli($server, $ds_username, $db_password, $database);

if($mysqli->connect_errno) {
  throw new Exception("MYSQL connection erro: ".$mysqli->connect_error);
}

if (
  !$mysqli->query("DROP TABLE IF EXISTS Dogs") ||
  !$mysqli->query("CREATE TABLE IF NOT EXISTS Dogs (
    dog_id CHAR(4),
    dog_name CHAR(20),
    dog_weight CHAR(3),
    dog_color CHAR(15),
    dog_breed CHAR(4)
  )") 
) {
  throw new Exception("Table can't be created or deleted".$mysqli->error);
}

foreach($this->dogs_array as $dogsKey=>$dogs_array) {
  foreach($dogs_array as $dogIndex=>$dogValue) {
    $dog_id = $dogValue['dog_id'];
    $dog_name = $dogValue['dog_name'];
    $dog_weight = $dogValue['dog_weight'];
    $dog_color = $dogValue['dog_color'];
    $dog_breed = $dogValue['dog_breed'];

    if (
      !$mysqli->query("INSERT INTO Dogs (
      dog_id,
      dog_name,
      dog_weight,
      dog_color,
      dog_breed
      ) VALUES (
      '$dog_id',
      '$dog_name',
      '$dog_weight',
      '$dog_color',
      '$dog_breed'
      )")
    ) {
      throw new Exception("Can't add new records: ".$mysqli->error);
    }
  }
}

?>