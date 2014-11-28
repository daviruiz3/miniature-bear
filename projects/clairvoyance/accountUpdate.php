<?php
	session_start();
	require_once("shared.php");
	
	function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}

	if (isset($_SESSION["psychicid"])) {
		$psychicid = $_SESSION['psychicid'];
		$user = $_SESSION['user'];
		//echo "Psychic ID found!";
		//print_r($_SESSION);
	}
	
	if (isset($_POST['currPass']) && isset($_POST['newPass']) && isset($_POST['confPass'])){
		$currPass = $_POST['currPass'];
		$newPass = $_POST['newPass'];
		$confPass = $_POST['confPass'];
	}
	
	if (isset($_POST['status']) && isset($_POST['fortune'])) {
		$status = $_POST['status']; //1 or 0
		$fortune = $_POST['fortune'];
	}
	
	if (isset($_POST['expdate'])) {
		$expdate = $_POST['expdate'] . ' 00:00:00';
		echo $expdate;
	} else {
		$expdate = null;
	}
	
	if (isset($_POST['changePass'])) {
		$testPassQuery = "SELECT entrance, salt FROM psychic WHERE id = ?";
		if($newPass == $confPass) {
			if($statement = $con->prepare($testPassQuery)){
				echo " we have prepared the statement ";
				//check the password
				$statement->bind_param("s", $psychicid);
				$statement->execute();
				$statement->bind_result($entrance, $salt);
				while($statement->fetch()){
					$currEntrance = $currPass . $salt;
					$dbEntrance = $entrance;
				}
			}
		}else{
			echo " Confirmation password mismatch ";
		}
			
		$query = "UPDATE psychic SET entrance = ?, salt = ? WHERE id = ?";
		if($currEntrance == $dbEntrance){
			if ($stmt = $con->prepare($query)) {
				echo " we have prepared the second statement ";
				$salt = randString(16);
				$password = $newPass.$salt;
				$stmt->bind_param("sss", $password, $salt, $psychicid);
				$stmt->execute();
				echo " Updated change pass ";
				header("Location: controlpanel.php");
			}else{
				echo " Didn't update account! ";
			}
		}
	}
				
	if (isset($_POST['createFortune'])) {
			//fortune, status, psychicid 	
		echo $fortune;
		echo $status;
		$query = "INSERT INTO fortune(fortune, id, creationDate, status, expirationDate, psychicid, showdowncount) values(?, uuid(), now(), ?, ?, ?, 0)";
		if ($stmt = $con->prepare($query)) {
			echo " we have prepared the second statement ";
			$stmt->bind_param("siss", $fortune, $status, $expdate, $psychicid);
			$stmt->execute();
			echo " Updated create fortune ";
			header("Location: controlpanel.php");
		}else{
			echo " Didn't update account! ";
		}
	}
?>