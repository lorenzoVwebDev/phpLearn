<?php
//we are now going to modify the Dog class to handle the modifications made in the interface tier with lab.php and dog_interface.php
class Dog {
// ------------------------------ Properties ------------------------------
private int $dog_weight = 0;
private string $dog_breed = "no breed";
private string $dog_color = "no color";
private string $dog_name = "no name";
private string $error_message = "??";
private $breedxml = "";
//We are now adding the $insert bool (to specify whether it is an insert or an update process)
private bool $insert = FALSE;
//the dog index will be inserted as well, by default is set to -1, indicating that the user either selected NEW or did not select a dog from the dogs list box (in lab.php)
private $index = -1;
?>