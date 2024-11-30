<?php

class dog_data {
  function _construct() {
    $xmlfile = file_get_contents("dog.xml");
    $xmlstring = simplexml_load_string($xmlfile);
    //json_encode() transforms the string in a wee structured json data like that: 
/*       {"dog":[{"dog_name":"Woff","dog_weight":"12","dog_color":"Yellow",
        "dog_breed":"Lab"},{"dog_name":"Sam","dog_weight":"10",
        "dog_color":"Brown","dog_breed":"Lab"}]
        } */
    $json = json_encode($xmlstring);
    //json_decode() creates a well structured associative array 
/*     Array ( [dog] =>
Array (
[0] => Array ( [dog_name] => Woff [dog_weight] => 12
[dog_color] => Yellow [dog_breed] => Lab )
[1] => Array ( [dog_name] => Sam [dog_weight] => 10
[dog_color] => Brown [dog_breed] => Lab )
) ) */
  //we can now use all the techniques to retrieve data from this array
    $dogs_array = json_decode($json, TRUE);
  }
}
?>