<?php
@$db = new mysqli('localhost','root','','pengyus_pizza');
// @ to ignore error message display //
if ($db->connect_error){
	echo "Database is not online"; 
	exit;
	// above 2 statments same as die() //
	}
/*	else
	echo "Congratulations...  MySql is working..";
*/
if (!$db->select_db ("pengyus_pizza"))
	exit("<p>Unable to locate the auth database</p>");
?>	
