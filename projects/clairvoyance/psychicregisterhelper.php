<?php
	require_once("shared.php");

	$form_check = '';
	$return_arr = array();
	
	function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	{
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}

	if(filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)){
	   $form_check = 'valid';
	}
	else {
		$form_check = 'invalid';
	}

	$return_arr["form_check"] = $form_check;

	if (isset($_POST['inputEmail']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['pass']) && isset($_POST['userName'])){
		$fname = $_POST['firstName'];
		$lname = $_POST['lastName'];
		$pw = $_POST['pass'];
		$email = $_POST['inputEmail'];
		$uname = $_POST['userName'];
		
		
		$return_arr["firstName"] = $fname;
		$return_arr["lastName"] = $lname;
		$return_arr["pass"] = $pw;
		$return_arr["email"] = $email;
		$return_arr["userName"] = $uname;
		$return_arr["insertResult"] = "test1";
		
		//query to check for unique username
		$testusernamequery = "SELECT nickname FROM psychic WHERE nickname LIKE ?";
		
		//make sure statement can be prepared, if not send error
		if($statement = $con->prepare($testusernamequery)){
			//make sure that username doesn't already exist
			$statement->bind_param( "s", $uname);
			$statement->execute();
			$statement->bind_result($district);
			$unique = $statement->fetch();
			#$row = $result->fetch_array(MYSQLI_NUM);
			
			#mysqli_stmt_close($statment);
			#is_null(mysqli_stmt_fetch($statment))
			if(is_null($unique)){
				//if uname doesn't exist go ahead and create a new record
				$query = "INSERT INTO psychic (id, givenName, surname, nickname, email, status, entrance, salt) VALUES (UUID(), ?, ?, ?, ?, 1, ?, ?)";
				//if($stmt = mysqli_prepare($con, "INSERT INTO psychic('id','givenName','surname','nickname','email','status','entrance')VALUES(UUID(),?,?,?,?,1,HEX(?),?)")){
				if ($stmt = $con->prepare( $query)) {
					$return_arr["insertResult"] = "test2";
					$salt = randString(16);
					$pw .=$salt;
					$stmt->bind_param( "ssssss", $fname, $lname, $uname, $email, $pw, $salt);
					$result = $stmt->execute();
					$stmt->close();
					$return_arr["insertResult"] = $result;
				}else{
					$return_arr["insertResult"] = $con->error;
				}
			}else{
				$return_arr["insertResult"] =  "existing username: " . $uname;
			}
		}else{
				$return_arr["insertResult"] = mysqli_error($link);
		}
	}

	echo json_encode($return_arr);
?>