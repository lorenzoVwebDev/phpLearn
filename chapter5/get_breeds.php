<?php
  //simplexml_load_file() places the content of the xml file in a variable
  $breed_file = simplexml_load_file("./xml/breeds.xml");
  //asXML() converts the content of $breed_file into a well formatted string.
  $xmlText = $breed_file->asXML();
  print "<select name='dog_breed' id='dog_breed'>";
  print "<option>Select a dog breed</option>";
  
/*   XML data is treated with a parent-child relationship. The    parent can contain children
  (and the children can have children). In the XML file, the initial parent is breeds. The
  children that exist under breeds all have the label breed.
  <breed>Affenpinscher</breed>
  The value in each breed (child) in this example is the text that exists between the
  breed tags (e.g., Affenpinscher). $breed_file->children() directs the foreach statement to loop through each child
  (breed in this file).*/
  foreach ($breed_file->children() as $name=> $value) {
    print "<option value='$value'>$value</option>";
  }

    print "</select>"
?>