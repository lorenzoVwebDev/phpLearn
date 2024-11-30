<?php
?>
<!-- we are now going to expand the script part of the lab.php file to populate the form when a user pick a pre-created dog from the dogs' list, the choice will populate each input element (color, breed, weight etc) with the respective choosed dog's parameters  -->
<script>
  
  function process_select() {
  //First, all the values of the html named dog_color will be pulled into and array due to getElementsByName(), this will give us an array with the colors in order. For instance the 0 position will always be 'brown' because brown is the first element, from the top, whose value is 'brown' in the html part of lab.php (the elements named 'dog_color' are the radio inputs).
  //This will create a node list that can be used in JS similarly to an array, each of the array's values (nodes) virtually contains every property related to its type, for instance we can both watch and the .checked html property of the node or change it dynamically throughout the page lifecycle
    var colorbuttons=document.getElementsByName('dog_color');
    //document.getElementById('dogs') get the HTML list box 
/*     <select id="dogs">
      <option value="-1">NEW</option> <!-- Placeholder or unselected -->
      <option value="0">Labrador</option> <!-- User sees "Labrador" -->
      <option value="1">Golden Retriever</option>
    </select> */
    //that has been created, the <option> elements are the value of the <select> element and they start from 0, so if .value is equal to -1, either no selection or NEW has been clicked. 
    if (!document.getElementById('dogs').value == -1) {
      //.selectedIndex is used to retrive the child elements of <select> (<option>), their indexes start from 1, so we have to remove 1 to create a value that we can use to retrieve data respectively from an array
      index = document.getElementById('dogs').selectedIndex -1;
      //it assaign the previous value to the hidden input:
/*       <input type="hidden" name="index" id="index"
      value= "-1"/> */
      document.getElementById('index').value=index;
      //it retrives the dog properties (dog_name, dog_weight etc) from the obj that was returned before by the AjaxRequest('e8dog_interface.php'); function (it contains all the dogs in a multidimensional array)
      document.getElementById('dog_name').value=obj.dogs[index].dog_name;
      document.getElementById('dog_weight').value=obj.dogs[index].dog_weight;
      //the code above paires the <option> of the <select> element (list box) to the obj array's value to retrive data and assign it toe the html input elements that correspond to the dog's characterictis (dog_name, dog_weight etc)
      //continue in labHtmlScript5.php
    }
  }
</script>