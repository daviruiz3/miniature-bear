<?php

//$con = mysqli_connect("localhost", "Devellectual", "QNvGVdZxzFCUdfND", "Devellectual-ProjectDB");
$con = new mysqli("localhost", "Devellectual", "QNvGVdZxzFCUdfND", "Devellectual-ProjectDB");

if ($con->connect_errno)
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function redirect($url) {
	header("Location: " . $url);
	die();
}

function check_log_in($queryParam) {
	return isset($queryParam["id"]) && isset($queryParam["first_name"]) 
			&& isset($queryParam["last_name"]);
}

function invalid_request() {
	header("HTTP/1.1 400 Invalid Request");
	die("An HTTP error 400 (invalid request) occurred. You must pass the necessary parameters.");
}
?>