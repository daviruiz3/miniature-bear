<?php 
require_once("top.php"); 

if ($_SERVER["REQUEST METHOD"] == "POST") {
	//firstName, lastName, userName, inputEmail, pass, confirmPass
	$fName = $_POST['firstName'];
	$lName = $_POST['lastName'];
	$uName = $_POST['userName'];
	$email = $_POST['inputEmail'];
	$pass = $_POST['pass'];
	$cPass = $_POST['confirmPass'];
	/*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//email isn't valid so do something
	}*/
}
?>
<script type="text/javascript">
console.log("hi");
</script>
	<h1>Psychic Registration</h1>
	<div>
		<form class="form-horizontal">
		  <div class="control-group">
			<label class="control-label" for="firstName">First</label>
			<div class="controls">
			  <input type="text" id="firstName" name="firstName" placeholder="First Name">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="lastName">Last</label>
			<div class="controls">
			  <input type="text" id="lastName" name="lastName" placeholder="Last Name">
			</div>
		  </div>	  
		  <div class="control-group">
			<label class="control-label" for="userName">Username</label>
			<div class="controls">
			  <input type="text" id="userName" name="userName" placeholder="Username">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
			  <input type="text" id="inputEmail" name="inputEmail" placeholder="Email">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="pass">Password</label>
			<div class="controls">
			  <input type="password" id="pass" name="pass" placeholder="Password">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="confirmPass">Confirm Password</label>
			<div class="controls">
			  <input type="password" id="confirmPass" name="confirmPass" placeholder="Confirm Password">
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			  <button type="submit" class="btn" id="register">Register</button>
			  <button id="clear" class="btn">Clear</button>
			</div>
		  </div>
		</form>
	</div>
	</div> <!-- end of container-->
	<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/register.js" type="text/javascript"></script>
  </body>
</html>