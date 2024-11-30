<?php
?>

<script>
  
  function process_select() {
    //this is used below in the if statements
    var colorbuttons=document.getElementsByName('dog_color');
    if (!document.getElementById('dogs').value == -1) {
      index = document.getElementById('dogs').selectedIndex -1;
      document.getElementById('index').value=index;
      document.getElementById('dog_name').value=obj.dogs[index].dog_name;
      document.getElementById('dog_weight').value=obj.dogs[index].dog_weight;
      //it retrieves the dog_color from obj,
      dog_color=obj.dogs[index].dog_color;
      //it dynamically change the checked property of the node if the condition is satisfied; if the checked property of a radio input is true, it appears as clicked (checked)
      // the "mixed" value is checked by default, so that we don't have to set it as true is case the dog_color would be "Mixed"
      if (dog_color =="Brown") {
        colorbuttons[0].checked = true;
      } else if (dog_color == "Black") {
        colorbuttons[1].checked = true;
      } else if (dog_color == "Yellow") {
        colorbuttons[2].checked = true;
      } else if (dog_color == "White") {
        colorbuttons[3].checked = true;
      }
      //it sets the value of the dog_breed input as equal as to the dog_breed value of the obj array 
      dog_breed=obj.dogs[index].dog_breed;
      document.getElementById('dog_breed').value=dog_breed;
      //these three lines below set the update and delete input elements visible, whereas the insert invisible to the user, that is because the user cannot insert a preexistent dog but just modify it
      document.getElementById('update').style.display="inline";
      document.getElementById('delete').style.display="inline";
      document.getElementById('insert').style.display="none";

    }
  }
</script>