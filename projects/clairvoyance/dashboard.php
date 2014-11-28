<?php
	/*
	if(!isset($_SESSION["psychicid"])){
		#header('Location: ./index.php');
	}
	*/
	session_start();

	if (isset($_SESSION["psychicid"])) {
		$psychicid = $_SESSION['psychicid'];
		$user = $_SESSION['user'];
		//echo "Psychic ID found!";
		//print_r($_SESSION);
	}/* else {
		header("Location: index.php");
	}*/
	//f, d, l, s, dis
	if (isset($_POST['f']) && isset($_POST['d']) && isset($_POST['s']) && isset($_POST['l']) && isset($_POST['dis']) && isset($_POST['a']) && isset($_POST['id'])) {
		$show_f = $_POST['f'];
		$show_d = $_POST['d'];
		if ($_POST['s'] == "activeStatus") {
			$show_s = "Active";
		} else {
			$show_s = "Inactive";
		}
		$show_l = $_POST['l'];
		$show_dis = $_POST['dis'];
		$show_app = $_POST['a'];
		$show_id = $_POST['id'];
		$show_fortune=true;
	} else {
		$show_fortune = false;
	}
	
	$scripts = array(array("type" => "css", "link" => "assets/css/dashboard.css"));
	require_once("top.php");
	require_once("shared.php");
	$query = "SELECT (SUM(fl.likes)-SUM(fl.dislikes)) FROM fortune f 
			JOIN fortuneList fl ON f.id = fl.fortune_id WHERE f.psychicid = ?";
		if ($statement = $con->prepare($query)) {
			$statement->bind_param("s", $psychicid);
			$statement->execute();
			$statement->bind_result($reputation);
			while ($statement->fetch()) {
				$show_rep = $reputation;
			}
		}
?>

<!--
INFO 461, Winter 2013
Devellectual
Provided HTML file for psychic control panel
-->
	<head>
		<title>Psychic Control Panel</title>
	</head>
	<script src="assets/js/jquery-1.9.1.min.js"></script>
		<script src="assets/js/bootstrap.js"></script>
		<script type="text/javascript">
  			var uvOptions = {};
  			(function() {
    		var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    		uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/HapdJfpfqiotNI1efoDQtQ.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  			})();
			
			$(window).load(function() {
				checkRadios();
				$('.radio input').change(checkRadios);
			});
			
			//checks radios and displays items accordingly
			function checkRadios() {
				if ($('#activeRadio').is(':checked')) {
					$('.activeStatus').css("display", "list-item");
					$('.inactiveStatus').css("display", "none");
				} else if ($('#inactiveRadio').is(':checked')) {
					$('.inactiveStatus').css("display", "list-item");
					$('.activeStatus').css("display", "none");
				}
			}
	</script>
	<body>
		<div class="container-fluid">
			<div class="logo-header"><img id="logo" src="logo.gif" alt="Clairvoyance"/></div>
			<div class="navbar navbar-fixed-top">
		      <div class="navbar-inner">
		        <div class="container-fluid">
		          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="brand" href="index.php">Clairvoyance</a>
		          <div class="nav-collapse collapse">
		            <p class="navbar-text pull-right">
						<a href="#" class="btn navbar-link">Hello,<i class="icon-user"></i><?=$user?><span class="text-success"> (<?=$show_rep?>) </span></a>
						<a href="logout.php" class="btn btn-mini btn-primary"><!--<button class="btn btn-mini btn-primary" type="button">-->Sign Out<!--</button>--></a>
		            </p>
		            <ul class="nav">
		              <li class="active"><a href="#">Dashboard</a></li>
		              <li><a href="controlpanel.php">Control Panel</a></li>
		            </ul>
		          </div>
		        </div>
		      </div>
		    </div>

		<div class="row-fluid">
			<div class="span6">
				<label class="radio"><input type="radio" name="optionsRadios" id="activeRadio" value="active" checked>Active</label>
				<label class="radio"><input type="radio" name="optionsRadios" id="inactiveRadio" value="inactive">Inactive</label>					
				<ul class="fortune-list">
					<?php 
						//grabs information from the table and sends it to the 
						$query = "SELECT f.id, f.fortune, MAX(f.creationDate), f.status, 
								  SUM(fl.likes), SUM(fl.dislikes), COUNT(fl.appliedDate) FROM fortune f 
								  LEFT JOIN fortuneList fl ON f.id = fl.fortune_id WHERE f.psychicid = ? GROUP BY f.id";
						if ($statement = $con->prepare($query)) {
							$statement->bind_param("s", $psychicid);
							$statement->execute();
							$statement->bind_result($id, $fortune, $date, $status, $likes, $dislikes, $applied);	
							while ($statement->fetch()) {
								$status = $status==1 ? "activeStatus" : "inactiveStatus";
								$likes = $likes===NULL ? 0 : $likes;
								$dislikes = $dislikes===NULL ? 0 : $dislikes;
					?>
					<!--We're gonna pass all the information as POST variables to the site itself so we can display it to the right-->
						<li class="<?=$status?> alert alert-info">
							<form class="fortuneLinks" action="dashboard.php" method="post">
								<input type="hidden" name="id" value="<?=$id?>"></input>
								<input type="hidden" name="d" value="<?=$date?>"></input>
								<input type="hidden" name="s" value="<?=$status?>"></input>
								<input type="hidden" name="l" value="<?=$likes?>"></input>
								<input type="hidden" name="dis" value="<?=$dislikes?>"></input>
								<input type="hidden" name="a" value="<?=$applied?>"></input>
								<input type="submit" name="f" value="<?=$fortune?>"></input>
							</form>
						</li>
					<?php }
						}
					?>
				</ul>
			</div>
			
			<div class="span6">
				<!--<img id="background" src="fortune.PNG" alt="fortune-background"/>-->
				<?php if ($show_fortune) { ?>
				<h2 id="fortune">"<?=$show_f?>"</h2>
				<div class="info">
					<div class="applied-info">
						<div class="likes">
							<a class="btn" href="#"><i class="icon-thumbs-up"></i></a>
							<?=$show_l?>
							<a class="btn" href="#"><i class="icon-thumbs-down"></i></a>
							<?=$show_dis?>
						</div>

						<div class="applied">
							Applied <?=$show_app?> times
							<div>Student Clients: </br>
							<?php 
							//grabs information from the table and sends it to the 
							$query = "SELECT s.username FROM student s 
									  JOIN fortuneList fl ON s.id = fl.student_id WHERE fl.fortune_id = ? GROUP BY s.username";
							if ($statement = $con->prepare($query)) {
								$statement->bind_param("s", $show_id);
								$statement->execute();
								$statement->bind_result($user);
								while ($statement->fetch()) {
									echo $user . " ";
								}
							}
							?>
							</div>
						</div>
					</div>
					<div class="active-info">
						<div class="active-btn">
							<button class="btn btn-success" type="button"><?=$show_s?></button>
						</div>
						<div class="last-applied">
							Last <?=$show_d?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>
		