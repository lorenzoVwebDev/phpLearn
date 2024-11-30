//this is the complete Ajax request file
function getXMLHttp() {
  var xmlHttp;
  try {
    xmlHttp = new XMLHttpRequest();
  }
  catch(e) {
    //Internet Explorer is different than the others
    try {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e) {
      try {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
        alert("Old browser? Upgrade today so you can use AJAX!")
        return false;
      }
    }
  }
  return xmlHttp;
}

function HandleResponse(response) {
	var responsevalues = response.split('|');
	document.getElementById('AjaxResponse').innerHTML = responsevalues[0]; 
	document.getElementById('AjaxReturnValue').innerHTML = responsevalues[1];
	return obj = JSON.parse(responsevalues[2]); 
}

function AjaxRequest(value) {
  var xmlHttp = getXMLHttp();
  //onreadystatechange defines a function to call whenever the readyState of the XMLHttp request changes
  xmlHttp.onreadystatechange = function() {
    //when the readyState becomes 4 it means that the process of request/response is complete, so it runs the HandleResponse()
    if(xmlHttp.readyState == 4) {
      //it runs the 
      HandleResponse(xmlHttp.responseText);
    }
  }
  xmlHttp.open("GET", value, true); 
  xmlHttp.send(null);
}


