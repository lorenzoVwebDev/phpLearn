<?php
session_start();
$user_log_file = "user.log";
$passed = FALSE;
//it recreates the whole json file
function saveupfile($dog_data_json,$valid_useridpasswords) {
    $newupstring='{"user":[';
	foreach($valid_useridpasswords as $users) {
        foreach($users as $index => $user) {
            if($index !== 0)  {
                $newupstring.=',',
            }
            $newupstring = '{"userid":"' . $user['userid'] . '","password":"' .$user['password'] . '","';
            $newupstring .= '"datestamp":"' . $user['datestamp'] . '","attempts":"'.$user['attempts'] . '","';
            $newupstring .= 'lastattempt":"' . $user['lastattempt'].'","validattempt":"' . $user['validattempt'] .'"}';
        }		
    } 
    $newupstring .= '"}\n]}';
	$new_valid_data_file = preg_replace('/[0-9]+/', '', $dog_data_json); 

    $oldxmldata = date('mdYhis') . $new_valid_data_file;
    if (!rename($dog_data_json, $oldxmldata)) {
	   throw new Exception("Backup file $oldxmldata could not be created.");
	}
    file_put_contents($new_valid_data_file,$newupstring);
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
			$dog_data_json = $xmlLocation->item(0)->nodeValue;
			break;
		}
    }} else {
	    throw new Exception("Dog applications xml file missing or corrupt");
	}
	return $dog_data_json;	
}

try {
if ((isset($_POST['username'])) && (isset($_POST['password']))) {
/*     
    JSON data would require some changes to accommodate the additional fields.
    {"user":[
    {"userid":"Fredfred","password":"$2y$10$VosI32FejL.bOMaCjGbBp.
    Jre6Ipa.tLYQrVqj9kiVpef5zZ25qQK","datestamp":"2015-09-03","attempts":
    "0","lastattempt":"08052015044229","validattempt": "08052015045431"},
    {"userid":"Poppoppop","password":"$2y$10$C1jXhTl0myamuLKhZx
    K5m.4X4TVcdeFbeLSBIA7l4fx6tUnC8vrg6","datestamp":"2015-09-
    04","attempts":"2","lastattempt":"08062015011347","validattempt":
    "08062015113038"}
    ]} */
    //this will directly transform the json format in an array;
    $valid_useridpasswords=json_decode($json,TRUE); 
	$userid=$_POST['username'];
	$password=$_POST['password'];

	$I=0;
	$passed=FALSE;

    foreach($valid_useridpasswords as $users) {

        foreach($users as $user) {
           
            if (in_array($userid, $user)) {
                $hash = $user['password'];
                
                $currenttime = strtotime(date('Y-m-d'));
                $stamptime = strtotime($user['datestamp']);
                
                if ($currenttime>$stamptime) {
                    
                    $_SESSION['message'] = "Your password has expired. Please create a new one.";
                    
                    header("Location: e75changepassword.php");
                } 
                 
                if (($user['attempts'] < 3) || (date('mdYhis', strtotime('-5 minutes'))>=$user['lastattempt'])) {
                    
                    if(password_verify($password,$hash)) {
                        
                        $passed = TRUE;
                        
                        $valid_useridpasswords['user'][$I]['validattempt'] = date('mdYhis'); 
                        $valid_useridpasswords['user'][$I]['attempts'] = 0; 					
                        $_SESSION['username'] = $userid;
                        $_SESSION['password'] = $password;
                        saveupfile($dog_data_json,$valid_useridpasswords); 
                        $login_string = date('mdYhis') . " | Login | " . $userid . "\n";
                        error_log($login_string,3,$user_log_file); 
                        
                        header("Location: e1lab.php");
                    } else {
                        
                        $valid_useridpasswords['user'][$I]['lastattempt'] = date('mdYhis'); 
                    }
                }	
            }
            
            $I++;		
        }
    }
			
	if (!$passed) {	
        
        $I--;	
        echo "Invalid Userid/Password";
        
        $valid_useridpasswords['user'][$I]['attempts'] = $user['attempts'] + 1;         
        saveupfile($dog_data_xml,$valid_useridpasswords);
	}
   }
 } catch (Exception $e) {
        echo $e->getMessage();
    }
 
?>
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required /><br />
<input type="submit" value="Login">
</form>