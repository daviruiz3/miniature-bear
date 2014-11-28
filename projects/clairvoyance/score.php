<?php
	require_once("shared.php");
	
	$query = "SELECT psychic.nickname, sum(showdowncount) FROM fortune left join psychic on fortune.psychicid = psychic.id group by psychic.id order by sum(showdowncount) desc";
	if($statement = $con->prepare($query)){
		$statement->execute();
		$statement->bind_result($psychic, $psychicscore);
		
	

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<!--
	INFO 461, Winter 2013
	Devellectual
	Provided php file for psychic showdown scoreboard
	-->
	<head>
		<title>Psychic Showdown Scoreboard</title>
		<link rel="stylesheet" href="assets/css/bootstrap.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap-responsive.css"></link>
		<link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"></link>
		<!--
			This is the CSS file for psychic showdown scoreboard.
		-->
		<link rel="stylesheet" href="score.css"></link>
		
	</head>
	
	<body>
		<h1>Scoreboard</h1>
		
		<div class="board">
			<ol class="centered">
			<?php
				while($row = $statement->fetch()){
			?>
				<li><?php echo $psychic . ' (' . $psychicscore . ')'  ;?></li>
			<?php
				}
			?>
			</ol>
		</div>
		<div class="option">
			<a href="showdown.php" class="btn btn-large" type="button">Replay</a>
			<a href="index.php" class="btn btn-large" type="button">Home</a>
		</div>
	<?php
	}else{
		echo $con->error;
	}
	?>
	</body>
</html>