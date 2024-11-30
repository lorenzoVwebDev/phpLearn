<?php
//login code
  session_start();
  //it checks whether the $_POST['username'] or the $_POST['password'] have been created yet
  if ((!isset($_POST['username'])) || (!isset($_POST['password']))) {
?>
<!-- if action is not specified, the submit input will just reload this page -->
<form method="post" action="">
<!--   pattern is used to enstablish a minimun required amount of characters -->
  Username: <input type="text" pattern=".{8, }"  title="User id must contain eight or more characters." name="username" id="username" required/><br/>
  <!-- required is used to specify that this input must be filled before submitting the information -->
  Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=
  .*[A- Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters." name="password" id="password" required/><br/>
  <input type="submit" value="Login">
</form>

<?php
} else {
//we are now going to create the session variables based on the previous username and password submitting
$_SESSION['username']=$_POST['username'];
$_SESSION['password']=$_POST['password'];
//$validUserIdPasswords is an associative array that contains all the username paired with the respective passwords
$validUserIdPasswords=array("sjohnson"=>"working");
//array_keys() creates an array whose valuse are the keys in the associative array in its argument
$valid_userids=array_keys($valid_useridpasswords);
$userid=$_SESSION['username'];
$password=$_SESSION['password'];
//in_array() checks whether a value(first argument) is present within an array
//$valid checks whether username and password are valid
$valid=(in_array($userid, $valid_userids)) && ($password == $validUserIdPasswords[$userid]);
//the header method is used to redirect to the next program to execute as long as it has the session_start() active
if($valid) {
  header("Location: lab2.php");
}
}
//for other ways to validate authentication in php: https://www.php.net/manual/en/features.http-auth.php  
?>