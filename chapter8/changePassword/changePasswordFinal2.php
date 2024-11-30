<?php
session_start();
$user_log_file = "user.log";
function saveupfile($uidpass_xml,$valid_useridpasswords) {
  $xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
  $xmlstring .= "\n<users>\n";        
  foreach($valid_useridpasswords as $users) {
    foreach($users as $user) {
        
        $xmlstring .="<user>\n<userid>" . $user['userid'] . "</userid>\n";
        $xmlstring .="<password>" . $user['password'] . "</password>\n";
        $xmlstring .="<datestamp>" . $user['datestamp'] . "</datestamp>\n";
        $xmlstring .= "<attempts>" . $user['attempts'] . "</attempts>\n";
        $xmlstring .= "<lastattempt>" . $user['lastattempt'] . "</lastattempt>\n";
        $xmlstring .= "<validattempt>" . $user['validattempt'] . "</validattempt>\n</user>\n";
        
    }		
  } 

  $xmlstring .= "</users>\n";
    
  $new_valid_data_file = preg_replace('/[0-9]+/', '', $uidpass_xml); 
  // remove the previous date and time if it exists
  $oldxmldata = date('mdYhis') . $new_valid_data_file;
  if (!rename($uidpass_xml, $oldxmldata)) {
    throw new Exception("Backup file $oldxmldata could not be created.");
  }
  file_put_contents($new_valid_data_file,$xmlstring);
}

function retrieve_useridpasswordfile() {

  $xmlDoc = new DOMDocument(); 
	if (file_exists("edog_applications.xml")) {
	  $xmlDoc->load( 'edog_applications.xml' ); 
	  $searchNode = $xmlDoc->getElementsByTagName( "type" ); 

		foreach($searchNode as $searchNode) { 
			$valueID = $searchNode->getAttribute('ID'); 
    
			if($valueID == "UIDPASS") {
        $xmlLocation = $searchNode->getElementsByTagName( "location" ); 
				$uidpass_xml = $xmlLocation->item(0)->nodeValue;
				break;
			}
		}
	} else {
		throw new Exception("Dog applications xml file missing or corrupt");
	}
	
	return $uidpass_xml;
	
}


if (!(isset($_SESSION['message']))) {
	// valid userid and password but password expired
	echo $_SESSION['message'];
}

try {
if((isset($_POST['username'])) && (isset($_POST['oldpassword'])) && (isset($_POST['password'])) && (isset($_POST['password_confirm']))) {

	libxml_use_internal_errors(true);
	$uidpass_xml = retrieve_useridpasswordfile();
	$xmlfile = file_get_contents($uidpass_xml);
	$xmlstring = simplexml_load_string($xmlfile);
	
	if ($xmlstring === false) {
		$errorString = "Failed loading XML: ";
		foreach(libxml_get_errors() as $error) {
			$errorString .= $error->message . " " ;  
    }
		throw new Exception($errorString); 
  }

	$json = json_encode($xmlstring);	
	$valid_useridpasswords = json_decode($json,TRUE); 
	$userid = $_POST['username'];
	$npassword = $_POST['password'];

  if(!(preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) || (!(strlen($userid)>=8))) {
    throw new Exception("Invalid Userid and/or Password Format");
  } else {
    $newpassword = password_hash($npassword, PASSWORD_DEFAULT);
    $password = $_POST['oldpassword'];
    $datestamp = date('Y-m-d', strtotime('+30 days'));
    $I = 0;
    $passed = FALSE;
    foreach($valid_useridpasswords as $users) {
    foreach($users as $user) {
    
      if (in_array($userid, $user)) {
        $hash = $user['password'];
        if(password_verify($password,$hash))  {
            $passed = TRUE;
            $valid_useridpasswords['user'][$I]['password'] = $newpassword;
            $valid_useridpasswords['user'][$I]['datestamp'] = $datestamp;
            $valid_useridpasswords['user'][$I]['attempts'] = 0;
            saveupfile($uidpass_xml,$valid_useridpasswords); // save changes before header call
            $login_string = date('mdYhis') . " | Password Changed | " . $userid . "\n";
            error_log($login_string,3,$user_log_file); 
            header("Location: e4login.php");
        }	
      }	
      $I++;
      }	
    }
      // drops to here if not valid password/userid or too many attempts	
      if(!$passed){		
        echo "Invalid Userid/Password";
      }
  }
	
   }
 
} catch(Exception $e) {
  echo $e->getMessage();
}
 
?>
<!-- If action is not specified, it reloads the same page -->
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br/>
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Old Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="oldpassword" id="oldpassword" required /><br />
New Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required="required" /><br />
<!-- check(this): "this" refers to the value of the input element, oninput="check(this)" runs the code in the JS script that checks whether the value in the password confirmation input is equal to the new password input -->
Confirm Password:<input name="password_confirm" required="required" type="password" id="password_confirm" oninput="check(this)"  />
<script language='javascript' type='text/javascript'>
  //it use javascript script to check the correct format of the new password
function check(input) {
  /* that checks whether the value in the password confirmation input is equal to the new password input */
if (input.value != document.getElementById('password').value) {
  //setCustomValidity() sets the message a browser will display when the validity is false
input.setCustomValidity('Password Must be Matching.');
} else {
// input is valid -- reset the error message
input.setCustomValidity('');
}
}
</script>
<input type="submit" value="submit">
</form>