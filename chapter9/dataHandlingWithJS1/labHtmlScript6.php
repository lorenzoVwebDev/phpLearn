<?php
?>

<script>
  
  function process_select() {
    var colorbuttons=document.getElementsByName('dog_color');
    if (!document.getElementById('dogs').value == -1) {
      index = document.getElementById('dogs').selectedIndex -1;
      document.getElementById('index').value=index;
      document.getElementById('dog_name').value=obj.dogs[index].dog_name;
      document.getElementById('dog_weight').value=obj.dogs[index].dog_weight;
      dog_color=obj.dogs[index].dog_color;
      if (dog_color =="Brown") {
        colorbuttons[0].checked = true;
      } else if (dog_color == "Black") {
        colorbuttons[1].checked = true;
      } else if (dog_color == "Yellow") {
        colorbuttons[2].checked = true;
      } else if (dog_color == "White") {
        colorbuttons[3].checked = true;
      }
      dog_breed=obj.dogs[index].dog_breed;
      document.getElementById('dog_breed').value=dog_breed;
      document.getElementById('update').style.display="inline";
      document.getElementById('delete').style.display="inline";
      document.getElementById('insert').style.display="none";

    } else {
      //it will be selected colorbuttons[4] due to its non existence, it will remove any checked true attribute from the other ones
      colorbuttons[4].checked=true;
      //these three lines below will empty these elements values
      document.getElementById('dog_name').value="";
      document.getElementById('dog_weight').value="";
      document.getElementById('dog_breed').value="Select a dog breed";
      document.getElementById('update').style.display="none";
      document.getElementById('delete').style.display="none";
      document.getElementById('insert').style.display="inline";
    }
    //it sets the whole form visible; notice that this line is essential in each of the two cases above determined by the main if statement
    document.getElementById('input_form').style.display = "inline";
  }
</script>