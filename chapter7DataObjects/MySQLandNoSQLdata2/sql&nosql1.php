<?php
  //Here it is an example on how to modify the dog_data class's constructor to access and update database information
  //When storage techinques are used, all database systems include data security tools to validate information before it is stored
  //mysqli_connect($server (server location), $db_username (database user ID), $db_password (database password), $database (database name)) connects us with the database; it also returns the "Connection object" that is essential to do query actions such as retrive data from the database or update it
  $con = mysqli_connect($server, $db_username, $db_password, $database);
  //msqli_connect_errno() returns the error code from the last connection attempt to the databse
  if(mysqli_connect_errno()) {
  //mysqli_connect_error() returns a description of the error from the last connection attempt to the database
    throw new Exception("MySQL connection error: ".mysqli_connect_error());
  }
  //the SELECT query statement is used to retrive the records (rows) FROM (another statement) the Dogs table; the * means "all columns"
  $sql="SELECT * FROM Dogs";
  //mysqli_query() executes the query, you have to pass both the "connection object" and the query; if the query executes successfully, $result will hold a result set which contains the retrieved data from the Dogs table. Otherwise, it will return false
  $result=mysqli_query($con, $sql);

  if ($result===null) {
    throw new Exception("No records retrieved from Database");
  }
  //mysqli_fetch_assoc() will convert the data into an array
  $this->dogs_array = mysqli_fetch_assoc($result);
  //After the result set has been retrieved from the database, it is allocated in memory, mysqli_free_result() removes it from memory
  mysqli_free_result($result);
  //mysqli_close() closes the connection with the database
  mysqli_close($con);

?>