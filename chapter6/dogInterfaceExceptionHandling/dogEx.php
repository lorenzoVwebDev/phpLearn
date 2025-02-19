<?php declare(strict_types=1);
class Dog
{
// ------------------------------ Properties ------------------------------
private int $dog_weight = 0;
private string $dog_breed = "no breed";
private string $dog_color = "no color";
private string $dog_name = "no name";
private string $error_message = "??";
private string $breedxml = "";
// ----------------------------- Constructor ------------------------------
function __construct($properties_array)
{
if (method_exists('dog_container', 'create_object')) {
$this->breedxml = $properties_array[4];
$name_error = $this->set_dog_name(
$properties_array[0]) == TRUE ? 'TRUE,' : 'FALSE,';
$color_error = $this->set_dog_color(
$properties_array[2]) == TRUE ? 'TRUE,' : 'FALSE,';
$weight_error= $this->set_dog_weight(
$properties_array[3]) == TRUE ? 'TRUE' : 'FALSE';
$breed_error = $this->set_dog_breed(
$properties_array[1]) == TRUE ? 'TRUE,' : 'FALSE,';
$this->error_message =
$name_error . $breed_error . $color_error . $weight_
error;
if(stristr($this->error_message, 'FALSE')) {

 throw new setException($this->error_message);
}
}
else { exit; }
}
function set_dog_name($value) : bool {
  $error_message = TRUE;
  (ctype_alpha($value) && strlen($value) <= 20) ?
  $this->dog_name = $value : $this->error_message = FALSE;
  return $this->error_message; 
}
function set_dog_weight($value) {
  $error_message = TRUE;
  (ctype_digit($value) && ($value > 0 && $value <= 120)) ?
  $this->dog_weight = $value : $this->error_message = FALSE;
  return $this->error_message; 
}
function set_dog_breed($value) {
  $error_message = TRUE;
  ($this->validator_breed($value) === TRUE) ?
  $this->dog_breed = $value : $this->error_message = FALSE;
  return $this->error_message; 
}
function set_dog_color($value) {
  $error_message = TRUE;
  (ctype_alpha($value) && strlen($value) <= 15) ?
  $this->dog_color = $value : $this->error_message = FALSE;
  return $this->error_message; 
}
// ------------------------------Get Methods-------------------------------
function get_dog_name() : string {
return $this->dog_name; }
function get_dog_weight() : int {
return $this->dog_weight; }
function get_dog_breed() : string {
return $this->dog_breed; }
function get_dog_color() : string{
return $this->dog_color; }

function get_properties() : string {
return "$this->dog_name,$this->dog_weight,$this->dog_breed,
$this->dog_color."; }
// -----------------------------General Method-----------------------------
private function validator_breed($value) : bool
{
$breed_file = simplexml_load_file($this->breedxml);
$xmlText = $breed_file->asXML();
if(stristr($xmlText, $value) === FALSE)
{
return FALSE;
}
else
{
return TRUE;
}
}
}

?>