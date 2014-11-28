<?php
	
	if ($_REQUEST['functionName'] == 'test') {
		if(isset($_REQUEST['inputvar'])){
			test($_REQUEST['inputvar']);
		}
	}
	
	function test($input){
		//echo $input;
		$query = 'UPDATE fortune SET showdowncount = showdowncount + 1 WHERE id = ?';
		$con = new mysqli("localhost", "Devellectual", "QNvGVdZxzFCUdfND", "Devellectual-ProjectDB");

		if ($con->connect_errno)
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		if($stmt = $con->prepare($query)){
			$stmt->bind_param("s", $input);
			$stmt->execute();
			echo "ran";
		}else{
			//echo $con->error;
		}
		//echo $query;
	}
	
	
	//echo 'success';

?>