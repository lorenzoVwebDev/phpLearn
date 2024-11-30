<?php
//session start declare that this script is part of an existing session, each session generates a unique id. As long as the user has not closed the session, the session ID will be attached to any program (script) that calls the session_start(), method; It is mandatory that the session_start() is placed before any existing code. This allow the script to access all porperties related to the current session.
session_start();
//isset($_SESSION['username']) isset($_SESSION['password']) checks wheter the username or password properties; as $_GET or $_POST, these properties are placed into an array ($_GET, $_POST) and we can access them by using computing values as we have done below
if ((!isset($_SESSION['username']))||(!isset($_SESSION['password']))) {
  echo "You must login to access the ABC Canine Shelter Reservation System";
  echo "<p>";
  //If neither is set, the user is redirected to the login page or the registration page
  echo "<a href='login.php'>Login</a> | <a href='register.php'>Create an account</a>";
  echo "</p>";
} else {
  echo "<p>Welcome back, ".$_SESSION['username']."</p>";
}
?>