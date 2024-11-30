<?php
session_start();
$user_log_file = "user.log";
try {
  if ((isset($_POST['username'])) || (isset($_POST['password']))) {
    $userid = $_POST['username'];
    $password = $_POST['password'];
    //it checks if either the password respects the right parameters or the userid is long enough
  if (!(preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password))||(!(strlen($userid)>=8))) {
    throw new Exception("Invalid Userid and/or Password Format");
  } else {
    Libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    if (file_exists("e7dog_applications.xml")) {
      $xmlDoc->load( 'e7dog_applications.xml' );
      $searchNode = $xmlDoc->getElementsByTagName("type");
      foreach( $searchNode as $searchNode ) {
        $valueID = $searchNode->getAttribute('ID');
        if ($valueID == "UIDPASS") {
          $xmlLocation=$searchNode->getElementsByTagName("location");
          $dog_data_xml=$xmlLocation->item(0)->nodeValue;
          break;
        }}} else {
          throw new Exception("Dog applications xml
          file missing or corrupt");
        }
  }
  //Registration part
  $password = password_hash($password, PASSWORD_DEFAULT);
  //MySql version
/*   $mysqli =mysqli_connect($server, $db_username, $db_password, $database);
  if (mysqli_connect_errno())
  {
  throw new Exception("MySQL connection error: " . mysqli_connect_
  error());
  }
  $sql="INSERT INTO Users (userid, password) VALUES('" . $userid . "','" .
  $password . "');";
  $result=mysqli_query($con,$sql);
  If($result===null)
  {
  throw new Exception("Userid/Password not added to Database");
  }
  mysqli_close($con);
  $login_string = date('mdYhis') . " | New Userid | " . $userid . "\n";
  error_log($login_string,3,$user_log_file);
  header("Location: e7login.php"); */
  $input = file_get_contents($dog_data_xml);
  $find = "</users>";
  $newupstring = "<user>\n<userid>" . $userid . "</userid>\n<password>".$password."</password>\n</user>\n</users>";
  $find_q = preg_quote($find,'/');
  $output = preg_replace("/^$find_q(\n|\$)/m", $newupstring,$input);
  file_put_contents($dog_data_xml,$output);
  $login_string = date('mdYhis')." | New Userid | ".$userid."\n";
  error_log($login_string,3,$user_log_file);
  //redirect us to the login page after the registration
  header("Location: login.php");
  //JSON version
  /*   
  JSON data would require just a couple of slight changes.
  {"user":
  [
    {"userid":"Fredfred","password":"$2y$10$VosI32FejL.bOMaCjGbBp.
    Jre6Ipa.tLYQrVqj9kiVpef5zZ25qQK"},
    {"userid":"Petepete","password":"$2y$10$FdbXxIVXmVOHtaBNxB8vzupRBJFCq
    UyOTJXrlpNdrL0HKQ\/U.jFHO"}
  ] }

  The data ends with a combination of ]}, which does not occur anywhere else. $find
  can be set to this value ($set = "]}";). The $newupstring value can also be changed to
  $newupstring = ',{"userid":"' . $userid . '","password":"' . $password .
  '"}\n]}';
  These two changes (along with the previous changes) would update a JSON file with
  a new user ID/password combination. 
  */
}} catch(Exception $e) { 
  echo $e->getMessage(); 
}
?>
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and
lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must
contain eight or more characters." name="username" id="username"
required/><br />
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-
Z]).{8,}" title="Password must contain at least one number, one
uppercase and lowercase letter, and at least 8 total characters."
name="password" id="password" required /><br />
<input type="submit" value="submit">
</form>