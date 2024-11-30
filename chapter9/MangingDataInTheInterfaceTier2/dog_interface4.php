<?php
//READ THE INTRODUCTION BELOW UNTILL THE END
//dog interface should request the dogs list box and the complet dogs array from the data tier to format and send to lab.php. dog_interface must request the dogs array information by calling the display method in dog_data.php
//we are going to se container NULL again to clean it from the previous $container variable:
/* else // breeds select box
{
$container = new dog_container("selectbox");
$properties_array = array("selectbox");
$lab = $container->create_object($properties_array);
$container->set_app("breeds");
$dog_app = $container->get_dog_application("breeds");
$method_array = get_class_methods($lab);
int $last_position = count($method_array) - 1;
$container = NULL;
$result = $lab->$method_name($dog_app); */
//(the code above is NOT the code from the previous dog_interface files that you can find in this folder, but another part after the else statement)
$container=null; 
//then we are going to create a new instance of the dog_container class specifying 'dog' in its constructor, this let us create an instance of the dog class 
$container=new dog_container("dog");
$properties="dog";
//Creates an object of the dog class in dog.php
$lab=$container->create_object($properties);
//not essential
$container->set_app("dog");
//it retrieves the xml file's name paired with the type "dog" in the dog_applications.xml
$dog_app=$container->get_dog_application("dog");
//it puts all the methods of the $lab instance's class
$method_array=get_class_methods($lab);
//create the index of the last array in the dog class
$last_position=count($method_array)-1;
//it retrives the last dog class' method (display_dog_data())
$method_name=$method_array[$last_position];
//the last method (display_dog_data()) retrives and run the last methods of the dog_data class, namely processRecords("Display",$record_Array), processRecords() contains a switch statement that if we passed display, it run the readRecords($record_Array) method of the dog_data class, whose main functionality is returning either the whole array, dogs_array["dog"], or the single dog (record) dogs_array["dog"][$recordNumber];
//In this case we have chosen for the whole dogs array due to the "ALL" argument
$returned_array=$lab->method_name("ALL");
?>