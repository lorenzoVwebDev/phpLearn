<?php
if (isset($_POST['ugo'])) {
  print "<h1> Mica </h1>";
} else {
  print "<html><head><title>PHP Example</title></head>";
  print "<form method='post' action='callmyself.php'>";
  print "<input type='submit' id='submitbutton' name='ugo' value='Find Hello World!'/>";
  print "</form>";
  print "</body></html>";
}
?>