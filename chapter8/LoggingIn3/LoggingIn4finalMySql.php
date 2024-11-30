<?php
session_start();
$user_log_file = "user.log";
$passed = FALSE;
//it recreates the whole json file
function saveupfile($dog_data_mysql,$valid_useridpasswords) {
    //it reconnects with the database
    $con =mysqli_connect($server, $db_username, $db_password, $database);
  if (mysqli_connect_errno())
  {
  throw new Exception("MySQL connection error: " . mysqli_connect_
  error());
  }
    //it loops through the array updating the new information for the users who has made the login, it updates the others as well but obviusly it don't change their values (datestamp, lastattempt etc.)
	foreach($valid_useridpasswords as $users) {
        foreach($users as $index => $user) {
            $userid = filter_var($user['userid'], FILTER_SANITIZE_STRING);
            $sql ="UPDATE Uidpass SET(datestamp='" . $user['datestamp'] . "',attempts='";
            $sql .=$user['attempts'] . "',lastattempt='" . $user['lastattempt'] . "',";
            $sql .="validattempt='" . $user['validattempt'] . "') WHERE userid='" .
            $userid . "';";
            $result=mysqli_query($con,$sql);
            If($result===null)
            {
            throw new Exception("Userid/Password not added to Database");
            }
        }		
    } 
    mysqli_close($con);
    $login_string = date('mdYhis') . " | New Userid | " . $userid . "\n";
    error_log($login_string,3,$user_log_file);
}

function retrieve_useridpasswordfile() {
    //this code retrives the whole Uidpass table, converts it into an array and returns it
    $con = mysqli_connect($server, $db_username, $db_password, $database);
    if(mysqli_connect_errno()) {
      throw new Exception("MySQL connection error: ".mysqli_connect_error());
    }
    $sql="SELECT * FROM Uidpass";
    $result=mysqli_query($con, $sql);
  
    if ($result===null) {
      throw new Exception("No records retrieved from Database");
    }
    //mysqli_fetch_assoc() will convert the data into an array
    $dog_data_mysql = mysqli_fetch_assoc($result);
    //After the result set has been retrieved from the database, it is allocated in memory, mysqli_free_result() removes it from memory
    mysqli_free_result($result);
    //mysqli_close() closes the connection with the database
    mysqli_close($con);
    return $dog_data_mysql;
}

try {
if ((isset($_POST['username'])) && (isset($_POST['password']))) {
    //it directly puts the array created from the table in the $vali_useridpasswords
    $valid_useridpasswords=retrieve_useridpasswordfile(); 
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
                        saveupfile($valid_useridpasswords); 
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