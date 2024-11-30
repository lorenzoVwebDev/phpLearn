<?php

class dog_data {
  function __construct() {
    //file _get_contents opens a text xml file, drops the contents into a string, and closes the file. 
    $xmlfile = file_get_contents("dog.xml");
    //simplexml_load_string() parses the file in a SimpleXMLELement object; so it transforms the $xmfile string in a php object with which it is easier to retrieve its properties
    //example
/*     Example Usage
Suppose $xmlfile contains the following XML data:

xml
Copia codice
<book>
    <title>PHP Programming</title>
    <author>John Doe</author>
    <price>29.99</price>
</book>
You can then use $xmlstring to access different elements:

php
Copia codice
$xmlfile = '<book><title>PHP Programming</title><author>John Doe</author><price>29.99</price></book>';
$xmlstring = simplexml_load_string($xmlfile);

echo $xmlstring->title;   // Output: PHP Programming
echo $xmlstring->author;  // Output: John Doe
echo $xmlstring->price;   // Output: 29.99 */

    $xmlstring = simplexml_load_string($xmlfile);
    //it transforms the object into an array
    //assuming that the xml file would be like that:
    /* <?xml version="1.0" encoding="UTF-8"?>
    <dogs>
    <dog>
    <dog_name>Woof</dog_name>
    <dog_weight>12</dog_weight>
    Chapter 7 Data ObjeCtsWOW! eBook
    www.wowebook.org
    268
    <dog_color>Yellow</dog_color>
    <dog_breed>Lab</dog_breed>
    </dog>
    <dog>
    <dog_name>Sam</dog_name>
    <dog_weight>10</dog_weight>
    <dog_color>Brown</dog_color>
    <dog_breed>Lab</dog_breed>
    </dog>
    </dogs> */

    //the output includes:
    /* Array ( [dog] => Array (
      [0] => SimpleXMLElement Object (
      [dog_name] => Woff [dog_weight] => 12
      [dog_color] => Yellow [dog_breed] => Lab )
      [1] => SimpleXMLElement Object (
      [dog_name] => Sam [dog_weight] => 10
      [dog_color] => Brown [dog_breed] => Lab )
      ) ) */
    $array = (array)$xmlstring;

    print_r($array);
  }
}
?>