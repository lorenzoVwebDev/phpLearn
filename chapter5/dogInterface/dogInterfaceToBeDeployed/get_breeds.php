<?php

  class GetBreeds {
    private $result = "??";

    function __construct($properties_array) {
      //get_breeds contructor
      if (!(method_exists('dog_container', 'create_object'))) {
        exit;
      }
    }

  public function get_select($dog_app) {
    if (($dog_app != FALSE) && (file_exists($dog_app))) {
        //simplexml_load_file() places the content of the xml file in a variable
      $breed_file = simplexml_load_file($dog_app);
        //asXML() converts the content of $breed_file into a well formatted string.
      $xmlText = $breed_file->asXML();
      $this->result ="<select name='dog_breed' id='dog_breed'>";
      $this->result =$this->result."<option value='-1' selected>
      Select a dog breed</option>";
        /*   XML data is treated with a parent-child relationship. The    parent can contain    children
        (and the children can have children). In the XML file, the initial parent is breeds. The
        children that exist under breeds all have the label breed.
        <breed>Affenpinscher</breed>
        The value in each breed (child) in this example is the text that exists between the
        breed tags (e.g., Affenpinscher). $breed_file->children() directs the foreach statement to loop through each child
        (breed in this file).*/
      foreach ($breed_file->children() as $name => $value) {
/*         print $value; */
        $this->result = $this->result . "<option value='$value'>$value</option>"; 
      } $this->result = $this->result ."</select>";
        return $this->result;
    } else {
      return FALSE;
    }
  }
}
?>