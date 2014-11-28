<?php
require_once("shared.php");

//echo "we have entered checklogin.php \n";
//print_r($_POST);
if (isset($_POST['user']) && isset($_POST['pass'])) {
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	//echo $user . ", " . $pass ."\n";
} else {
	//redirect back to login with error
	echo "no post values returned";
}

$query = "SELECT id, nickname, entrance, salt FROM psychic WHERE nickname = ?";
if ($statement = $con->prepare($query)) {
	echo "statement was prepared";
	$statement->bind_param("s", $user);
	$statement->execute();
	$statement->bind_result($id, $dbuser, $dbpass, $salt);
	while ($statement->fetch()) {
		if ($pass . $salt == $dbpass) {
			//redirect to dashboard.html
			//create session
			session_start();
			$_SESSION['psychicid'] = $id;
			$_SESSION['user'] = $user;
			header('Location: dashboard.php');
		} else {
			echo "user does not exist or password mismatch";
		//user does not exist
		}
	}
} else {
	echo "did not prepare statemenet D;";
}

?>