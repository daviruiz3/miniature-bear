<?php 
/*set script variable to include css or javascript files in header
	e.g.
	scripts = array(array("type" => "css", "link" => "assets/css/index.css"));
*/
$scripts = array(array("type" => "css", "link" => "assets/css/index.css"));
require_once("top.php");

?>
    
	<div class='container'>
		<div class="row">
			<div class="span6" id="buttonGame">
				<div class='header'><img id="logo" src="logo.gif" alt="Clairvoyance"/></div>
				<a class="btn btn-large btn-primary"  href="showdown.php">Play Game</a>
				<a class="btn btn-large btn-primary" href="https://twitter.com/">Twitter</a>
			</div>
			
			<div class="span6">
			  <form class="form-signin" id="psychicLogin" method="post" action="checklogin.php">
				<h2 class="form-signin-heading">Psychic Login</h2>
				<input type="text" class="input-block-level" name='user' placeholder="Username">
				<input type="password" class="input-block-level" name='pass' placeholder="Password">
				<label class="checkbox"><input type="checkbox" value="remember-me"> Remember me</label>
				<button class="btn btn-large btn-primary" type="submit">Sign in</button>
				<div>New to Clairvoyance? <a href="psychicRegister.php">Sign up</a></div>
			  </form>
			  
			  <form id="twitterSubscribe" class="form-signin" action="redirect.php">
				<h2 id="tweet_subhead">
					<?php 
						session_start();
						if($_SESSION['status']=='verified'){
							echo $_SESSION['access_token']['screen_name'] . ' Registered!';
						}else{
							echo "Want to receive fortunes?";
						}
					?>
				</h2>
				
				<button class="btn btn-large btn-primary" >Subscribe</button> 
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="en" data-size="large" data-count="none">Tweet</a>
				<?php
					if($_SESSION['status'] == 'verified'){
					?>
					<p>
						<a href="<?php echo $_SESSION['access_token']['user_id']; ?>" id="unsubscribe">Unsubscribe</a>
					</p>
					<?php
					}
				?>
			  </form>
			</div>
	  </div>
	</div> <!-- /container -->
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<script type="text/javascript">
  		var uvOptions = {};
  		(function() {
    	var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    	uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/HapdJfpfqiotNI1efoDQtQ.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  		})();
	</script>
	<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/index.js" type="text/javascript"></script
  </body>
</html>
