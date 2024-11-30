<?php 
// same code as constructor from Chapter 7 with some minor changes
session_start();
try {
  $user_log_file = "user.log";
  if ((isset($_POST['username'])) || (isset($_POST['password']))) {
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    //it retrives the uidpass.xml file 
    if ( file_exists("dog_applications.xml") ) {
      $xmlDoc->load( 'dog_applications.xml' );
      $searchNode = $xmlDoc->getElementsByTagName( "type" );
      
      foreach($searchNode as $searchNode ) {
        $valueID = $searchNode->getAttribute('ID');
        // changed value to UIDPASS
        if($valueID == "UIDPASS") {
          $xmlLocation=$searchNode->getElementsByTagName( "location" );
          //change $this->dog_data_xml to dog_data_xml
          //values created in a loop are accessible even outside it
          $dog_data_xml=$xmlLocation->item(0)->nodeValue;
          break;
        }
      }
    } else {
      throw new Exception("Dog applications xml file missing or corrupt");
    }
    //it loads the uidpass.xml content in an array using the $dog_data_xml variable
    $xmlfile = file_get_contents($dog_data_xml);
    $xmlstring = simplexml_load_string($xmlfile);
    if ($xmlstring === false) {
      $errorString = "Failed loading XML: ";
      foreach(libxml:get_errors() as $error) {
      $errorString .= $error->message . " " ; 
      }
      throw new Exception($errorString); 
    }
    
    $json=json_encode($xmlstring);
    // changed array name to $valid_useridpasswords
    $valid_useridpasswords=json_decode($json,TRUE);
    //to use json, we will just use the example from chapter 7,
/*     $json = file_get_contents(uidpass.json);
    $this->dogs_array = json_decode($json,TRUE);
    if ($this->dogs_array === null && json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("JSON error: " . json_last_error_msg());
    }  */
    //the json file with the users must be formatted like that:
/*    {"user":
        [
        {"userid":"Fredfred","password":"$2y$10$VosI32FejL.bOMaCjGbBp.
        Jre6Ipa.tLYQrVqj9kiVpef5zZ25qQK"},
        {"userid":"Petepete","password":"$2y$10$FdbXxIVXmVOHtaBNxB8vzupRBJFCq
        UyOTJXrlpNdrL0HKQ\/U.jFHO"}
        ] } */
    // ...... code to verify userid and password ....
    $userid=$_POST['username'];
    $password=$_POST['password'];
    foreach($valid_useridpasswords as $users) {
      foreach($users as $user) {
        $hash=$user['password'];
        //if password and user are correct, this code opens lab.php (authentication2.php), otherwise, it runs the code below
        if((in_array($userid, $user)) && (password_verify($password,$hash))) {
          $_SESSION['username'] = $userid;
          $_SESSION['password'] = $password;
          $login_string = date('mdYhis')." | Login | ".$userid . "\n";
          error_log($login_string,3,$user_log_file);
          header("Location: lab.php");
        } 
      } 
    } 
  }
} catch(Exception $e) {
  echo $e->getMessage();
}
// code below executes if the user has not logged in or if it is an invalid login
?>
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br/>
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username"
required/><br/>
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A- Z]).{8,}" title="Password must contain at least one number, one
uppercase and lowercase letter, and at least 8 total characters." name="password" id="password" required /><br/>
<input type="submit" value="Login">
</form>