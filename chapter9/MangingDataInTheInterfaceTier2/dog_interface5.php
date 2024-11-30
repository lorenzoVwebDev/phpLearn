<?php
//this code below continue the previous code
//we are now going to format the dogs list box.
//this will be used by lab.php to portray the list box of all the dogs
$resultstring="<select name='dogs' id='dogs'>";
//as before, the NEW value has been set to -1, this allows the creation of a new dog and doesn't retrive the options of the other dogs
$resultstring=$resultstring."<option value='-1' selected>NEW</option>";
//$returned_array is served at the second level of the dogs array yet, so we don't have to loop it as before on two levels:
foreach($returned_array as $dogIndex=>$dogValues) {
  //
  $resultstring=$resultstring."<option value='$dogIndex'>".$dogValues['dog_name'];
  //$nbsp is an html entity that stands for "non-breaking space"
  $resultstring.="&nbsp;&nbsp;&nbsp;".$dogValues['dog_breed']."</option>";
}
//VERY IMPORTANT: this printed output will be get bey the Ajax in lab.php (getlist7.js in the dataHandlingWithJS1 folder, the code in Ajax then proceds to spli this printed output in an array, whatch getlists7.php to better understand the process)
print $result . "|" . $resultstring . "|" . '{ "dogs" : ' . json_
encode($returned_array) . "}";
?>