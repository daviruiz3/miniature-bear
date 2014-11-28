<?php 
	/*set script variable to include css or javascript files in header
	e.g.
	scripts = array(array("type" => "css", "link" => "assets/css/index.css"));
	*/
	session_start();

	if (isset($_SESSION["psychicid"])) {
		$psychicid = $_SESSION['psychicid'];
		$user = $_SESSION['user'];
		//echo "Psychic ID found!";
		//print_r($_SESSION);
	}

	$scripts = array(array("type" => "css", "link" => "assets/css/controlpanel.css")); 
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
		<!--<link rel="stylesheet" href="controlpanel.css"></link>-->
	</head>

	<body>
		<!--<div class="container-fluid">-->
		<div class="hero-unit"><h1><img id="logo" src="logo.gif" alt="Clairvoyance"/></h1></div>

		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container-fluid">
	          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="brand" href="#">Clairvoyance</a>
	          <div class="nav-collapse collapse">
	            <p class="navbar-text pull-right">
					<a href="#" class="btn navbar-link">Hello, <i class="icon-user"></i><?=$user?><span class="text-success">(<?=$show_rep?>)</span></a>
					<a href="logout.php"><button class="btn btn-mini btn-primary" type="button">Sign Out</button></a>
	            </p>
	            <ul class="nav">
	              <li><a href="dashboard.php">Dashboard</a></li>
	              <li class= "active"><a href="#">Control Panel</a></li>
	            </ul>
	          </div>
	        </div>
	      </div>
	    </div>
		

		<!-- Contact Site Admin -->
		<div class="container">
			<div class="row">
				
				<div class="span4">
					<!--SideBar Content -->
					<h3><a class="btn" href="#"><i class="icon-user"></i><?=$user?></a></h3>

					<!--Change Status of account-->
					<!-- Changing account password-->
					<form id="accountChange" action="accountUpdate.php" method="post">
						<select name="status">
							<option name="status" value="active" selected>Active</option>
							<option name ="status" value="inactive">Inactive</option>
						</select>
						<div class="control-group">
							<label class="control-label" for="currPass">Current Password: </label>
							<div class="controls">
								<input type="text" id="currPass" name="currPass" placeholder="Current Password">
							</div>
					  	</div>

					  	<div class="control-group">
							<label class="control-label" for="newPass">New Password: </label>
							<div class="controls">
								<input type="text" id="newPass" name="newPass" placeholder="New Password">
							</div>
					  	</div>

					  	<div class="control-group">
							<label class="control-label" for="confPass">Confirm Password: </label>
							<div class="controls">
								<input type="text" id="confPass" name="confPass" placeholder="Old Password">
							</div>
					  	</div>

						<div class="control-group">
							<div class="controls">
								<input class="btn btn-primary" name="updateAccount" type="submit"></input>
							</div>
						</div>
					</form>
					<div id="updateError" class="error alert-error">
					</div>
				</div>

				<!-- Edit\delete Fortune -->
				<div class="span4">
					<h3 class="create"> Create A Fortune </h3>	
					<form id="createFortune" action="accountUpdate.php" method="post">
						<textarea maxlength="120" style="resize: none;" rows="4" cols="10" placeholder="Enter a fortune." name="fortune" spellcheck="true"></textarea>
						<label for="active" class="radio"><input type="radio" name="status" id="active" value="1" checked>Active</label>
						<label for="inactive" class="radio"><input type="radio" name="status" id="inactive" value="0">Inactive</label>
						<label>Expiration Date: <input type="text" class="datepicker" name="expdate"/></label>
						<div class="control-group">
							<div class="controls">
								<input class="btn btn-primary" name="createFortune" type="submit"></input>
							</div>
						</div>
					</form>
				</div>

				<!-- List of fortunes Created By Current Psychic-->
				<div class="span4">
					<h3> Fortunes Created </h3>
						<?php 
							$query = "SELECT f.fortune, f.id, f.creationDate, f.status, f.expirationDate, fl.fortune_id 
									  FROM fortune f LEFT JOIN fortuneList fl ON f.id = fl.fortune_id WHERE f.psychicid = ? GROUP BY f.id";
							if ($statement = $con->prepare($query)) {
								$statement->bind_param("s", $psychicid);
								$statement->execute();
								$statement->bind_result($fortune, $id, $creatDate, $status, $expDate, $app_fortune);								
								while ($statement->fetch()) {
						?>			
								<form class="fortuneEdit" action="editfortune.php" method="post">		
								<?php		
									$status = $status==1 ? "active" : "inactive";
									if($status == "active" ){
								?>
										<div class="alert alert-success">
								<?php
									}else{
								?>		
										<div class="alert alert-error">
								<?php		
									} 
								?>
											Fortune: <?=$fortune?> <br />
											Created: <?=$creatDate?> <br/> 
											Expires: <?=$expDate?> <br />
											<input type="hidden" name="fortune_id" value="<?=$id?>"></input>
											
								<?php if (is_null($app_fortune)) { ?>
								
										<!--<input type="submit" class="edit" name="edit" value="Edit"></input>-->
										<a href="#EditModal" role="button" class="btn edit" name="edit" value="Edit" data-toggle="modal">Edit</a>
										<input type="submit" class="delete" name="delete" value="Delete"></input>
								<?php } ?>
								
										</div>
									</form>
									
									<!-- Modal -->
									<div id="EditModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h3 id="editFortune">Edit Fortune</h3>
									  </div>
									  
									  <form class="fortuneEdit" action="editfortune.php" method ="post">
									  <div class="modal-body">
										
											<select name="status">
												<option name="status" value="1">Active</option>
												<option name ="status" value="0">Inactive</option>
											</select>
											<textarea maxlength="120" style="resize: none;" rows="4" cols="10" placeholder="Enter a fortune." name="fortune" spellcheck="true"><?=$fortune?></textarea>
											<label>Expiration Date: <input type="text" class="datepicker" name="expdate"/></label>
											
										
									  </div>
									  <div class="modal-footer">
									  <input type="hidden" name="fortuneid" value="<?=$id?>"></input>
									  <input type="submit" class="edit" name="edit" value="Save Changes"></input>
							
										<!--<input type="submit" class="btn btn-primary">Save changes</input>-->
									  </div>
									  
									  </form>
									</div>

						<?php
								}
							}
						?>
				</div>
			</div>
		</div>
		<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script>
		var uvOptions = {};
			(function() {
			var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
			uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/HapdJfpfqiotNI1efoDQtQ.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
			})();

			$( ".datepicker" ).datepicker({
					dateFormat : 'yy-mm-dd'
			});
		</script>
	</body>