<?php
//lab.php first access
session_start();
if ((!isset($_SESSION['username']))||(!isset($_SESSION['password']))) {
  echo "You must login to access the ABC Cnine Shelter Reservation System";
  echo "<p>";
  echo "<a href='login.php'>Login</a> | <a href='register.php'>Create an account</a>";
  echo "</p>";
  //the superglobal variable $_SERVER['HTTP_REFERER'] contains the webpage that referred the current one, for example: If the user was on login.php and clicked a link to another page (e.g., dashboard.php), $_SERVER['HTTP_REFERER'] on dashboard.php would contain http://127.0.0.1:8080/mysite/bgchapter8/ExampleFile8/login.php
} else if (($_SERVER['HTTP_REFERER']=='http://127.0.0.1:8080/mysite/bgchapter8/ExampleFile8/login.php')||($_SERVER['HTTP_REFERER']=='http://127.0.0.1:8080/mysite/bgchapter8/ExampleFile8/lab.php')) {
  //lab.php will return a session message that will be echoed
  if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    //login.php doesn't return any session message, so the markup below will be echoed
  } else {
    echo "<p>Welcome back, ".$_SESSION['username']."</p>";
  }
}
?>