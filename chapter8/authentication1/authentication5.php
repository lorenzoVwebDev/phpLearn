<?php
//extractingUserIdAndPasswordFromXml
//this below is the xml file that we are going to extract both the username and the hashed passwords from
  //uidpass.xml
  /* users>
  <user>
  <userid>Fredfred</userid>
  <password>$2y$10$VosI32FejL.bOMaCjGbBp.Jre6Ipa.tLYQrVqj9kiVpef
  5zZ25qQK</password>
  </user>
  <user>
  <userid>Petepete</userid>
  <password>$2y$10$FdbXxIVXmVOHtaBNxB8vzupRBJFCqUyOTJXrlpNdrL0HKQ
  /U.jFHO</password>
  </user>
  </users> */
  $xmlfile = file_get_contents('uidpass.xml');
  //it transforms the file in a string
  $xmlstring = simplexml_load_string($xmlfile);
  if ($xmlstring === false) {
    $errorString = "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
      $errorString .= $error->message . " " ; 
    }
    
    throw new Exception($errorString); }
    //transforms the string in a well structured json data
    $json = json_encode($xmlstring);
    //it creates an array from the $json
    $valid_useridpasswords = json_decode($json,TRUE);
    $userid=$_POST['username'];
    $password=$_POST['password'];
    foreach($valid_useridpasswords as $users) {
      //we are now going to retrive both the username and the passwords from the array
      foreach ($users as $user) {
        $hash=$user['password'];
        if ((in_array($userid, $user)) && (password_verify($password, $hash)) {
          $_SESSION['username']=$userid;
          $_SESSION['password']=$hash;
          header("Location: lab.php");
        })

      }
    }
?>