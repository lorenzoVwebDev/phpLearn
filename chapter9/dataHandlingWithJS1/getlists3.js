//This is how the Ajax script will handle the response, this response will be used in this part of the lab.php html code
/* <script>
    AjaxRequest('e8dog_interface.php');
  </script> */
function HandleResponse(response) {
  //split() creates an array dividing the text using the pipeline symbol |, this will create, in order, the breeds list box, dogs list box and the dogs array values, this will creatly reduce the calls that Ajax does to just one
  var responsevalues= response.split('|');
  //displays the getBreeds lis
  document.getElementById('AjaxResponse').innerHTML=responsevalues[0];
  //displays the dogs list box
  document.getElementById('AjaxReturnValue').innerHTML=responsevalues[1];
  //parses responsevaluse[2], that is a JSON style formatted array in a JS object
  obj=JSON.parse(responsevalues[2]);
}