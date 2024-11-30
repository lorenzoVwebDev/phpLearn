<?php
//Login script: we need to log any new log in the xml, we must take note of the expiration of the login session (datestamp), number of attempts, last attempt (when it was done, written in date('mdYhis'))
/*
<users>
 <user>
 <userid>Fredfred</userid>
 <password>$2y$10$VosI32FejL.bOMaCjGbBp.Jre6Ipa.tLYQrVqj9kiVpef 
5zZ25qQK</password>

 <datestamp>2015-09-03</datestamp>
 <attempts>0</attempts>
 <lastattempt>08052015044229</lastattempt>
 <validattempt>08052015045431</validattempt>
 </user>
 <user>
 <userid>Poppoppop</userid>
 <password>$2y$10$C1jXhTl0myamuLKhZxK5m.4X4TVcdeFbeLSBIA7l4fx6tU
nC8vrg6</password>
 <datestamp>2015-06-04</datestamp>
 <attempts>1</attempts>
 <lastattempt>08062015113200</lastattempt>
<validattempt>08062015113038</validattempt>
 </user>
</users>*/


$newupstring = "<user>\n<userid>" . $userid . "</userid>\n<password>" . 
$hashed_password . "</password>\n";
//strtotime() this is used to set an expiration date for the password, in this context, the expiration date is set 30 days ahead the subscribe date
/* In the last example, strtotime is used in a different way to set an already expired date when creating multiple user accounts in bulk. Imagine a scenario where a course management system needs to add a large number of student accounts all at once. Instead of manually setting an expiration date for each account, we can use strtotime to set the "password expiration" date for each new account as the previous day (or any past date). This would look something like strtotime('-1 day'), which generates a timestamp for "yesterday." */
/*Another way to use day stamp to fr3ate s3varal users at once
By assigning a past expiration date to each account at creation, the system immediately considers these passwords expired.
    This approach forces users to change their passwords upon their first login. It's a simple way to ensure that all users create unique passwords, 
        which enhances security for newly created accounts.*/


$newupstring .= "<datestamp>" . date('Y-m-d', strtotime('+30 days')) . 
"</datestamp>\n";
//if the user's attempts are more than 3, the user must wait five minutes or more to try the access again
$newupstring .= "<attempts>0</attempts>\n<lastattempt>".date('mdYhis') . 
"</lastattempt>\n";
$newupstring .= "<validattempt>".date('mdYhis')."</validattempt>\n 
</user>\n</users>";

?>