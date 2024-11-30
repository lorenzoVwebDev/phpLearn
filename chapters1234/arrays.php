<?php
  $array = array (
    "css",
    3,
    4
  );

  $array[] = "hello world";

/*   print $array[3] . "<br>"; */

  //output: hello world

  //associative array: it pairs keys and values to easily retrive array's values

  $class_array["class number"] = "css";

/*   print $class_array["class number"]; */

  //output: css

  //associative arrays can even be built in this way 

  $class_array2 = array (
    "greet" => "hello world",
    "name" => "ugo"
  );

/*   print $class_array2["name"]; */

  //output: ugo
//foreach loop: after the "as" statement, we have to declare the name of the iterations
  foreach($class_array2 as $value) {
    print $value . "<br>";
  }

//output: 
//hello world
//ugo

/////

//array_merge() merges arrays togheter,
//print_r offers a clear view of the variables

$colors1 = array("red", "green");
$colors2 = array("blue", "yellow");
$result = array_merge($colors1, $colors2);
print_r($result);
//output: Array ( [0] => red [1] => green [2] => blue [3] => yellow )

?>