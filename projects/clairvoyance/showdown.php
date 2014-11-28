<?php
	$round = 0;

	if(isset($_GET['round'])){
		if($_GET['round'] == 10){
			header( 'Location: score.php' ) ;
		}else{
			$round = $_GET['round'];
		}
	}
	require_once("shared.php");
	
	$fortunearr = array();
	$fortuneidarr = array();
	//need to make sure status is 1
	$qr = 'select fortune.id, fortune from fortune join psychic on psychic.id = fortune.psychicid where psychic.status = 1 && fortune.status = 1 && expirationDate > NOW()';
	$fortunearrlength;
	if($getfortunes = $con->prepare($qr)){
		#echo 'test </br>';
		$getfortunes->execute();
		#echo 'test </br>';
		$getfortunes->bind_result($fortuneid, $fortune);
		#echo 'test </br>';
		$i=0;
		while($row = $getfortunes->fetch()){
			$fortunearr[$i] = $fortune;
			$fortuneidarr[$i] = $fortuneid;
			//echo count($fortunearr) . ' ' . $fortunearr[$i] . '</br>';
			//echo rand(0, count($fortunearr)-1) . '</br>';
			$i++;
		}
		//NEED TO DO SOME SORT OF WHILE LOOP TO MAKE SURE TWO DIFFERENT FORTUNES ARE AQUIRED*******************************
		//picks a random fortune and saves it in rand fortune 1
		$rand_fortune1 = rand(0, count($fortunearr)-1);
		$rand_fortune2 = rand(0, count($fortunearr)-1);
		
		$rand_fortune1 = rand(0,count($fortunearr)-1);
		do {
		  $rand_fortune2 = rand(0,count($fortunearr)-1);
		} while ($rand_fortune1 == $rand_fortune2);

		//get the length of the fortune array not sure why this is done though
		$fortunearrlength = count($fortunearr)-1;
		// echo $fortunearr[$selectnum] . '</br>';
	}
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<!--
	INFO 461, Winter 2013
	Devellectual
	Provided php file for psychic showdown
	-->
	<head>
		<title>Psychic Showdown</title>
		<link rel="stylesheet" href="assets/css/bootstrap.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap-responsive.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"></link>
		<!--
			This is the CSS file for psychic showdown.
		-->
		<link rel="stylesheet" href="showdown.css"></link>
		
		
	</head>
	
	<body>
		<div class="container">
			<div class="option">
				<a href="score.php" class="left">Show Scoreboard</a>
				<a href="<?php echo 'showdown.php?round='. $round;?>" class="right">Skip&gt;&gt;</a>
			</div>
			
			<div class="span4 left">
				<h2 class="quote"> 
					"<?php echo $fortunearr[$rand_fortune1] ?>"
				</h2>
				<form action="">
					<input type="button" name="<?php echo $fortuneidarr[$rand_fortune1] ?>" class="button" id="bt1" value="Select" title="">		
				</form>
			</div>
			
			<div class="span4 right">
				<h2 class="quote"> 
					"<?php echo $fortunearr[$rand_fortune2] ?>" 
				</h2>
				<form action="">
					<input type="button" name="<?php echo $fortuneidarr[$rand_fortune2] ?>" class="button" id='bt2' value="Select" title="">
				</form>			
			</div>
		</div>
		<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="assets/js/showdown.js" type="text/javascript"></script>
	</body>
</html>