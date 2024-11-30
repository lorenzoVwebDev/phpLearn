<?php

?>
<body onload="checkJS();">
<h1>ABC Canine Shelter Reservation System</h1>
<div id="JS">
<script>
    AjaxRequest('e8dog_interface.php');
</script>
  <h3>Pick the dog name and breed to change from the dropdown box, then click the button.<br>
  For new dog information select
  'NEW'.
  </h3>
  Select 'NEW' or Dog's Name/Breed 
<!-- This div below will contain the return of the Ajax function that creates the dogs list box -->
<div id="AjaxReturnValue">
</div>
<!-- this button below executes the process_select() function when clicked -->
<input type="button" name="selected" id="selected" value="Click to
select" onclick="process_select()" /><br><br>
<div id="input_form">
  <!-- This form below will be show after clicking the button above -->
<form method="post" action="e8dog_interface.php">
  <h3>Please note the required format of information.</h3>
  <hr>
  Enter Your Dog's Name (max 20 characters, alphabetic) <input type="text" pattern="[a-zA-Z]*" title="Up to 20 Alphabetic Characters" maxlength="20" name="dog_name" id="dog_name" required/><br/><br/>
  Select Your Dog's Color:<br/>
  <input type="radio" name="dog_color" id=
  "dog_color" value="Brown">Brown<br />
  <input type="radio" name="dog_color" id=
  "dog_color" value="Black">Black<br />
  <input type="radio" name="dog_color" id=
  "dog_color" value="Yellow">Yellow<br />
  <input type="radio" name="dog_color" id=
  "dog_color" value="White">White<br />
  <input type="radio" name="dog_color" id=
  "dog_color" value="Mixed" checked >Mixed
  <br /><br />
  Enter Your Dog's Weight (numeric only) <input type="number" min="1" max="120" name="dog_weight" id="dog_weight" required /><br /><br />
  <input type="hidden" name="dog_app" id="dog_app" value="dog" />
  Select Your Dog's Breed <div id="AjaxResponse">
  </div><br />
  <!-- this input type gives an index to the dog, this property will be changed when the user selects a dog -->
  <input type="hidden" name="index" id="index"
  value= "-1"/>
  <!-- These three buttons are used to determine which action the user requests -->
  <input type="submit" name="insert" id="insert"
  value="Click to create your dog info" />
  <input type="submit" name="delete" id="delete"
  value="Click to remove your selected dog info" />
  <input type="submit" name="update" id="update"
  value="Click to update your selected dog info" />
  <hr>
</form>
</div>
</div>

