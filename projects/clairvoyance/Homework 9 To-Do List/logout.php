<?php
	/*Augustus Yuan 1027965
	CSE 190MX Tanner
	HW9 Remember the Cow: This page serves to log the user out. This means, once the user has
	logged out, all data of the user's session will be erased and they will not be able to access
	the to-do list unless the provide the appropriate information. It will also redirect them
	to the homepage.*/
	session_start();
	session_destroy();
	session_regenerate_id(TRUE);
	header("Location: index.php");
?>