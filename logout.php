<!-- Created by Matthew Urban
		This file handles logout.
	-->

<?php



#logging out and returning to login page
session_start(); 
session_destroy();

header('Location: login.php');
exit();
?>