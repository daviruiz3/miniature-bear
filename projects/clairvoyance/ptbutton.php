<?php
/*This is a test page I am making, we will use it to post tweets without a timer*/ 
	$scripts = array(array("type" => "js", "link" => "assets/js/tweetposthelper.js"));
	require_once("top.php");
?>			
			
			<form action="posttweet.php">
				<input type="submit" value="Post Tweets" />
			</form>
	</body>
</html>