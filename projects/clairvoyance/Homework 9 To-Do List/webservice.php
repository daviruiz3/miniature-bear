<?php
/*Augustus Yuan 1027965
CSE 190MX Tanner
HW9 Remember the Cow: This page serves to check if the user has put in the appropriate login
information. If the user does not, it will redirect them to the index.php page. If the login
is correct, the page will redirect the user to the todolist. It will also remember that the user
is logged in.*/
session_start();
include("shared.php");
//when to-do list starts and there is a list to provide
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (file_exists("list.json")) {
		header('Content-type: application/json');
		print(file_get_contents("list.json"));
	}
//else if the to-do list is being changed and we need to update it
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
  # process a POST request
	$data = check_param("todolist");
	file_put_contents("list.json", $data);  
}
?>