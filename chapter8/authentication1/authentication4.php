<?php
//password hashing
//We are going to change the previous validation code by using the password_verify()method that compare a password with an hashed password (assuming that $valid_useridpasswords[$userid] is an hashed password)
$valid = (in_array($userid, $valid_userids)) && (password_verify($password, $valid_useridpasswords[$userid]));

?>