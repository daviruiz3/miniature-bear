<?php
	/*Augustus Yuan 1027965
	CSE 190MX Tanner
	HW9 Remember the Cow: This page serves as the first page. After the user enters the information,
	the site will verify if the information is correct. If it is, the site will be redirected to the 
	to-do list. If the login isn't right, the user will be redirected back to this page with an error
	message.*/
	session_start();
	if (isset($_SESSION["login"])) {
		header("Location: todolist.php");
	}
	$login = "";
	if (isset($_GET["login"])) {
		$login = $_GET["login"];
	}
	include('top.html');
?>
	<div id="main">
		<p>
			The best way to manage your tasks. <br />
			Never forget the cow (or anything else) again!
		</p>

		<p>
			Log in now to manage your to-do list:
		</p>

		<form id="loginform" action="login.php" method="post">
			<div><input id="name" name="name" type="text" size="12" autofocus="autofocus" /> <strong>User Name</strong></div>
			<div><input id="password" name="password" type="password" size="12" /> <strong>Password</strong></div>
			<div><input id="submitbutton" type="submit" value="Log in" /></div>
		</form>
		<?php if ($login == "fail") { ?>
			<p id="error">
				Incorrect user name / password.  Please try again.
			</p>
		<?php } ?>
	</div>
<?php include('bottom.html');?>
