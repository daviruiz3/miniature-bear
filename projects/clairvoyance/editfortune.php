<?php
	session_start();
	require_once("shared.php");
	
	print_r($_POST);
	
	if (isset($_SESSION["psychicid"])) {
		$psychicid = $_SESSION['psychicid'];
		$user = $_SESSION['user'];
		//echo "Psychic ID found!";
		//print_r($_SESSION);
	}
	
	if(isset($_POST['fortuneid'])){
		$id = $_POST['fortuneid'];
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

	if (isset($_POST['edit'])) {
		echo $fortune . "<br/>";
		echo $status . "<br/>";
		echo $expDate . "<br/>";
		echo $id . "<br/>";
		//fortune, status, psychicid 	
		//echo $fortune;
		//echo $status;
		$query = "UPDATE fortune SET fortune = ?, status = ?, expirationDate = ? WHERE id = ?";
		 if ($stmt = $con->prepare($query)) {
			 //echo " we have prepared the second statement ";
			$stmt->bind_param("siss", $fortune, $status, $expdate, $id);
			$stmt->execute();
			 //echo " Updated create fortune ";
			 header("Location: controlpanel.php");
		 }else{
			 echo " Didn't update account! ";
		 }
		echo "TEST";
	}

	if (isset($_POST['delete'])) {
		//echo "WE ARE DELETORZ";
		$query = "DELETE FROM fortune WHERE id = ?";
		if ($stmt = $con->prepare($query)) {
			//echo "statement prepared";
			$stmt->bind_param("s", $id);
			$stmt->execute();
			//echo "fortune deleted";
			header("Location: controlpanel.php");
		}
	}

?>