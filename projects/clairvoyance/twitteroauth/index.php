<?php require_once("top.html"); ?>
	<link rel="stylesheet" href="assets/css/index.css">
    <div class="container">
	<h1>Clairvoyance</h1>
	  <div id="signin_sidebar">
		  <form class="form-signin" id="psychicLogin">
			<h2 class="form-signin-heading">Psychic Login</h2>
			<input type="text" class="input-block-level" placeholder="Username">
			<input type="password" class="input-block-level" placeholder="Password">
			<label class="checkbox">
			  <input type="checkbox" value="remember-me"> Remember me
			</label>
			<button class="btn btn-large btn-primary" type="submit">Sign in</button>
		  </form>
		  <form id="twitterSubscribe" class="form-signin" action="redirect.php">
			<h2 id="tweet_subhead">Want to receive fortunes?</h2>
			<button class="btn btn-large btn-primary" >Subscribe</button>
		  </form>
	  </div>
	</div> <!-- /container -->
	
	<!--debugging code-->
	<?php
		echo date("DATE_RSS");
		echo " time</br>";
		session_start();
		Print_r($_SESSION);
		echo "session </br>";
		Print_r($_REQUEST);
		echo "request </br>";
		Print_r($_COOKIE);
		echo "cookie </br>";
		Print_r($_POST);
		echo "post </br>";
		Print_r($_GET);
		echo "get </br>";
		#echo "tacos";
	?>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>
