<?php declare(strict_types=1);
function error_check_dog_app($lab) {
list($name_error, $breed_error, $color_error, $weight_error) =
//string 
explode(',', (string)$lab);
print $name_error == 'TRUE' ? 'Name update successful<br/>' :
'Name update not successful<br/>';
print $breed_error == 'TRUE' ? 'Breed update successful<br/>' :
'Breed update not successful<br/>';
print $color_error == 'TRUE' ? 'Color update successful<br/>' :
'Color update not successful<br/>';
print $weight_error == 'TRUE' ? 'Weight update successful<br/>' :
'Weight update not successful<br/>';
}
function get_properties($lab) {
print "Your dog's name is " . $lab->get_dog_name() . "<br/>";
print "Your dog weights " . $lab->get_dog_weight() . " lbs. <br />";
print "Your dog's breed is " . $lab->get_dog_breed() . "<br />";
print "Your dog's color is " . $lab->get_dog_color() . "<br />";
}
//----------------Main Section-------------------------------------
if ( file_exists("dog_container.php")) { 
  //even if scooped, the required file is avaible for the entire script
  require_once("dog_container.php"); } else { 
    print "System Error #1"; exit; }

if (isset($_POST['dog_app'])) {
  if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed'])) && (isset($_POST['dog_color'])) && (isset($_POST['dog_weight']))) { 
    $container = new Dog_container(filter_var($_POST['dog_app'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $dog_name = filter_var( $_POST['dog_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dog_breed = filter_var( $_POST['dog_breed'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dog_color = filter_var( $_POST['dog_color'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dog_weight = filter_var( $_POST['dog_weight'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $properties_array = array($dog_name,$dog_breed,$dog_color,$dog_weight);
    var_dump($properties_array);
    $lab = $container->create_object($properties_array);

    if ($lab != FALSE) {
      error_check_dog_app($lab);
      get_properties($lab); 
    } else { 
      print "System Error #2"; }

  } else {
    print "<p>Missing or invalid parameters.
    Please go back to the dog.html page to enter valid
    information.<br />";
    print "<a href='dog.html'>Dog Creation Page</a>";
  }
} else {

    $container = new Dog_container("selectbox");
    $properties_array = array("selectbox");
    $lab = $container->create_object($properties_array);

    if ($lab != FALSE) {
      print $lab->get_select('breeds.xml');
    } else {
      print "System Error #4";
    }
}
?>