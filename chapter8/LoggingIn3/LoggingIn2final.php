<?php
session_start();
$user_log_file = "user.log";
$passed = FALSE;
//saveupfile() recreates the uidpass xml file and creates the backup one as well
function saveupfile($dog_data_xml,$valid_useridpasswords) {
    $xmlstring='<?xml version="1.0" encoding="UTF-8"?>';
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
	$new_valid_data_file = preg_replace('/[0-9]+/', '', $dog_data_xml); 
    // remove the previous date and time if it exists
    $oldxmldata = date('mdYhis') . $new_valid_data_file;
    if (!rename($dog_data_xml, $oldxmldata)) {
	   throw new Exception("Backup file $oldxmldata could not be created.");
	}
    file_put_contents($new_valid_data_file,$xmlstring);
}
//retrieve_useridpasswordfile() retrieves the uidpass.xml file
function retrieve_useridpasswordfile() {
    $xmlDoc = new DOMDocument(); 
	if (file_exists("edog_applications.xml")) {
	$xmlDoc->load( 'edog_applications.xml' ); 
	$searchNode = $xmlDoc->getElementsByTagName( "type" ); 
    foreach($searchNode as $searchNode) { 
		$valueID = $searchNode->getAttribute('ID'); 
        if($valueID == "UIDPASS") {
            $xmlLocation = $searchNode->getElementsByTagName( "location" ); 
			$dog_data_xml = $xmlLocation->item(0)->nodeValue;
			break;
		}
    }} else {
	    throw new Exception("Dog applications xml file missing or corrupt");
	}
	return $dog_data_xml;	
}

try {
if ((isset($_POST['username'])) && (isset($_POST['password']))) {
	libxml_use_internal_errors(true);
    //retrives the uidpass.xml	files name
	$dog_data_xml=retrieve_useridpasswordfile();
	$xmlfile=file_get_contents($dog_data_xml);
	$xmlstring = simplexml_load_string($xmlfile);	
	if ($xmlstring === false) {
		$errorString = "Failed loading XML: ";
		foreach(libxml_get_errors() as $error) {
			$errorString .= $error->message . " " ;  
        }
	    throw new Exception($errorString); 
    }
	$json=json_encode($xmlstring);	
    $valid_useridpasswords=json_decode($json,TRUE); 
	$userid=$_POST['username'];
	$password=$_POST['password'];
    //$I will be used to set the proper $user array's index and modify it (We cannot modify global variables inside methods/functions' scoops, otherwise we will use & (references))
	$I=0;
	$passed=FALSE;
    //it loops through the array of all the users;
/*     Array (
    [user] => Array
        (
            [0] => Array
                (
                    [userid] => Fredfred
                    [password] => $2y$10$VosI32FejL.bOMaCjGbBp.Jre6Ipa.tLYQrVqj9kiVpef5zZ25qQK
                    [datestamp] => 2020-09-03
                    [attempts] => 0
                    [lastattempt] => 08052020044229
                    [validattempt] => 08052020045431
                )

            [1] => Array
                (
                    [userid] => Poppoppop
                    [password] => $2y$10$8xzP2XCGyEVKSuTOB7enjua5lZybhkkqXj6kOSFaEKyE3A22Am90q
                    [datestamp] => 2020-09-05
                    [attempts] => 0
                    [lastattempt] => 08062020042256
                    [validattempt] => 08062020042443
                )

        )
    ) */
    foreach($valid_useridpasswords as $users) {

        foreach($users as $user) {
            //it checks whether $userid exists in the $user array and lauch the whole code below (it checks if the user name exists yet)
            if (in_array($userid, $user)) {
                $hash = $user['password'];
                //strtotime() parses a date into a number, output: 1700697600
                $currenttime = strtotime(date('Y-m-d'));
                $stamptime = strtotime($user['datestamp']);
                //it checks whether the password expiration date is passed or not.
                if ($currenttime>$stamptime) {
                    // password expired force password change
                    $_SESSION['message'] = "Your password has expired. Please create a new one.";
                    //it relocates the user to the change password interface
                    header("Location: e75changepassword.php");
                } 
                //it checks wheter the attempts have been more than 3 or he has not tried the login within the last 5 minutes and then run the code 
                if (($user['attempts'] < 3) || (date('mdYhis', strtotime('-5 minutes'))>=$user['lastattempt'])) {
                    //it compares the password entered by the user with the password contained in the array (uidpass.xml) (it checks if the password is right)
                    if(password_verify($password,$hash)) {
                        //it sets the $passed boolean as true
                        $passed = TRUE;
                        //it updates the validattempt value to the current date
                        $valid_useridpasswords['user'][$I]['validattempt'] = date('mdYhis'); // shows last time successful login
                        //reset the number of attempts to 0
                        $valid_useridpasswords['user'][$I]['attempts'] = 0; // successful login resets to zero
                        //sets the $_SESSION[] array values as $$userid and $password					
                        $_SESSION['username'] = $userid;
                        $_SESSION['password'] = $password;
                        //it runs the saupfile() function that recreates the whole uidpass.xml
                        saveupfile($dog_data_xml,$valid_useridpasswords); // save changes before header call
                        //it adds a new string to the access log file with the new login
                        $login_string = date('mdYhis') . " | Login | " . $userid . "\n";
                        error_log($login_string,3,$user_log_file); 
                        //it redirects to lab.php (the dog creation interface)
                        header("Location: e1lab.php");
                    } else {
                        //it set the last attempt date
                        $valid_useridpasswords['user'][$I]['lastattempt'] = date('mdYhis'); // last attempted login
                    }
                }	
            }
            //at each loop it increases the $I value by 1, that's essential to modify the $valid_useridpasswords array and store the index t
            $I++;		
        }
    }
		// drops to here if not valid password/userid or too many attempts	
	if (!$passed) {	
        //$I is reduced by one because it is increased at the end of the previous loop, so for the code after it, we must decrease $I by one to have the actual index again
        $I--;	
        echo "Invalid Userid/Password";
        //this will add a further attempts in case the password is not wrong
        $valid_useridpasswords['user'][$I]['attempts'] = $user['attempts'] + 1; // add 1 to attempts
        // then, it runs saveupfile() ass well
        saveupfile($dog_data_xml,$valid_useridpasswords);
	}
   }
 } catch (Exception $e) {
        echo $e->getMessage();
    }
 
?>
<!-- it outputs this html in case either username or password are wrong -->
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required /><br />
<input type="submit" value="Login">
</form>