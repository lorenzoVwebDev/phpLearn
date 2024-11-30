<?php declare(strict_types=1);
Require_once("dog.php");
//$_POST['input_name'] is an associative array passed to the current script (lab.php in this case) via the HTTP POST method (otherwise, it would have been changed its name based on the method) that pair the name attribute with the current value
//$[$_POST]


if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed']))&& (isset($_POST['dog_color']))&&(isset($_POST['dog_weight']))) {
  //filter_var() filter a value (scalar values are transformed into strings) based on its second argument, FILTER_SANITIZE_FULL_SPECIAL_CHARS transforms all the tags and HTML-encode double annd single quotes in text
  $dog_name = filter_var( $_POST['dog_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $dog_breed = filter_var( $_POST['dog_breed'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $dog_color = filter_var( $_POST['dog_color'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $dog_weight = filter_var( $_POST['dog_weight'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  print $dog_name;

/*   $lab = new Dog('Fred','Lab','Yellow','100');

  list($name_error, $breed_error, $color_error, $weight_error) = explode(',', $lab);

  print $name_error == 'TRUE' ? 'Name update successful<br/>' : 'Name update not successful<br/>';
  print $breed_error == 'TRUE' ? 'Breed update successful<br/>' : 'Breed update not successful<br/>';
  print $color_error == 'TRUE' ? 'Color update successful<br/>' : 'Color update not successful<br/>';
  print $weight_error == 'TRUE' ? 'Weight update successful<br/>' : 'Weight update not successful<br/>';

  // ------------------------------Set Properties--------------------------
  $dog_error_message = $lab->set_dog_name('Sally');
  print $dog_error_message == TRUE ? 'Name update successful<br/>' : 'Name update not successful<br/>';

  $dog_error_message = $lab->set_dog_weight('5');
  print $dog_error_message == TRUE ? 'Weight update successful<br />' : 'Weight update not successful<br />';

  $dog_error_message = $lab->set_dog_breed('Labrador');
  print $dog_error_message == TRUE ? 'Breed update successful<br />' : 'Breed update not successful<br />';

  $dog_error_message = $lab->set_dog_color('Brown');
  print $dog_error_message == TRUE ? 'Color update successful<br />' : 'Color update not successful<br />';
  // ------------------------------Get Properties--------------------------
  print $lab->get_dog_name() . "<br/>";
  print $lab->get_dog_weight() . "<br />";
  print $lab->get_dog_breed() . "<br />";
  print $lab->get_dog_color() . "<br />";
  $dog_properties = $lab->get_properties();
  list($dog_weight, $dog_breed, $dog_color) = explode(',', $dog_properties);
  print "Dog weight is $dog_weight. Dog breed is $dog_breed. Dog color is $dog_color."; */
} else {
  print "<p>Missing or invalid parameters. Please go back to the lab.
  html page to
  enter valid information.<br />";
  print "<a href='lab.html'>Dog Creation Page</a>";
}


?>