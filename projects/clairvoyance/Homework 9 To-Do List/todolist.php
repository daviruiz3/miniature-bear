<?php
	/*Augustus Yuan 1027965
	CSE 190MX Tanner
	HW9 Remember the Cow: This page serves to check if the user has put in the appropriate login
	information. If the user does not, it will redirect them to the index.php page. If the login
	is correct, the page will redirect the user to the todolist. It will also remember that the user
	is logged in.*/
	session_start();
	if (!isset($_SESSION["login"])) {
		header("Location: index.php");
	}
	include('top.html');
?>
		<div id="main">
			<h2><?=$_SESSION["login"]?>'s To-Do List</h2>

			<ul id="todolist"></ul>

			<div id="buttons">
				<input id="itemtext" type="text" size="30" autofocus="autofocus" />
				<button id="add">Add to Bottom</button>
				<button id="delete">Delete Top Item</button>
			</div>

			<ul>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
<?php include('bottom.html');?>
