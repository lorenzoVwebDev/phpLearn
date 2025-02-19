function getXMLHttp(){
  var xmlHttp;
  try {
    xmlHttp = new XMLHttpRequest();
  } catch(e) {
// for old Internet Explorer users it is different than the others
    try {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(e) {
        alert("Old browser? Upgrade today so you can use AJAX!")
      return false;
      };
    };
  }
  return xmlHttp;
};

function AjaxRequest() {
  var xmlHttp = getXMLHttp();

  xmlHttp.onreadystatechange = function() {
    if(xmlHttp.readyState == 4) {
      console.log(xmlHttp)
      HandleResponse(xmlHttp.responseText);
    }
  };

  xmlHttp.open("GET", "new.php", true);
  // replace name with any PHP program
  xmlHttp.send(null);
  };

function HandleResponse(response) {
  document.getElementById('AjaxResponse').innerHTML = response;
};