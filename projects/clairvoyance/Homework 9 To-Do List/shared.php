<?php
//function that takes in a paramater and makes sure it is set and/or not blank
//if it is, the function will throw a 400 Invalid Request Error
function check_param($var) {
	if (!isset($_POST[$var]) || $_POST[$var] == "") {
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request: missing required parameter '$var'");
	}
	return $_POST[$var];
}
?>