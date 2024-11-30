<?php
//we are now going to store a new user in the users xml file
//$_POST is used wheter the username and the password have been POSTED from html 
if ((isset()$_POST['username']) || (isset($_POST['password']))) {
  $userid = $_POST['username'];
  $password = $_POST['password'];
  //preg_match() checks if $password respects the parameters specified with regex
  if(!(preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) || (!(strlen($userid)>=8))) {
    throw new Exception("Invalid Userid and/or Password Format");
  } else {
    //password_hash() hashes the password
    $password=password_hash($password; PASSWORD_DEFAULT);
 
    /* 
    <users>
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
    </users> 
    */
        //$dog_data_xml=uispass.xml  
    $input=file_get_contents($dog_data_xml);
    $find="</users>";
    //$newupstring is the the new user paired with its password that has to be added in the new $dog_data_xml file
    $newupstring="<user>\n<userid>".$userid."</userid>\n<password>".$password;
    $newupstring.="</password>\n</user>\n</users>";
    //preg_quote() escapes any special regex character, in the second argument we can select a further character to escape, in this case the forwardslash
    $find=preq_quote($find,'/');
    //preg_replace() deletes $find from $input either it has a newspace \n or not, then it replaces it with "", finally, it returns the original string without $find (</users>), this is used to add a
    $output=preg_replace("/^$find(\n|\$)/m","",$input);
    //it appends $newupstring to $output (the modified uispass.xml file)
    $output=$output.$newupstring;
    //file_put_contents() then rewrite the whole file using $output
    file_put_contents($dog_data_xml,$output);
    $login_string=date('mdYhis')." | New Userid | ".$userid."\n";
    error_log($login_string,3,$user_log_file);
    header("Location: login.php");
  }
}
?>