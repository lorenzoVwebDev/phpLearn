<?php
//We are now going to create a change password script that validates the old password and then allows the creation of the new ones. It also has to change the datestamp (the date that the last password was created on)
$userid=$_POST['username'];
$password=$_POST['password'];
$newpassword=password_hash($npassword, PASSWORD_DEFAULT);
$password=$_POST['oldpassword'];
$datestamp=date('Y-m-d', strtotime('+30 days'));
//$I is used to change the $valid_useridpasswords without using references, as before, it will be increased by one at each loop
$I=0;
$passed=FALSE;
//The code below represents what is inside the loop used even before: 
  /* foreach($valid_useridpasswords as $users) {

        foreach($users as $user) { */
//The one created by parsing the uidpass.xml into an array
//It retrives the old password
$hash=$user['password'];
//It checks whether the password inserted during the verification process is the actual old password
if(password_verify($password, $hash)) {
  //It sets passed as TRUE
  $passed=TRUE;
  //These three lines change in order the user's password, datestamp (password expiration date) and the number of attempts.
  $valid_useridpasswords['user'][$I]['password']=$newpassword;
  $valid_useridpasswords['user'][$I]['datestamp']=$datestamp;
  $valid_useridpasswords['user'][$I]['attempts']=0;
  //It runs the saveupfile() that rewrites the uidpass.xml file with the new user's details
  saveupfile($dog_data_xml, $valid_useridpasswords);
  //It logs the changes in the log file
  $login_string=date('mdYhis')." | Password Changed | ".$userid."\n";
  error_log($login_string, 3, $user_log_file);
  //finally, it redirects the user to the login page
  header("Location: login.php")
} else {
  $valid_useridpasswords['user'][$I]['lastattempt']=date('mdYhis');
}
?>