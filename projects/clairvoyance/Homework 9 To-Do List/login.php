<?php
	/*Augustus Yuan 1027965
	CSE 190MX Tanner
	HW9 Remember the Cow: This page serves to check if the user has put in the appropriate login
	information. If the user does not, it will redirect them to the index.php page. If the login
	is correct, the page will redirect the user to the todolist. It will also remember that the user
	is logged in.*/
	session_start();
	include("shared.php");
	$user = check_param("name");
	$pass = check_param("password");	
	if ($user == "augbog" && $pass == "12345") {
		$_SESSION["login"] = $user;
		header("Location: todolist.php");
	} else {
		header("Location: index.php?login=fail");
	}
?>