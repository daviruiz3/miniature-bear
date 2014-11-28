<?php 
	/*set script variable to include css or javascript files in header
	e.g.
	scripts = array(array("type" => "css", "link" => "assets/css/index.css"));
	*/
	$scripts = array(array("type" => "css", "link" => "assets/css/controlpanel.css")); 
	require_once("top.php"); 
?>
<!--
INFO 461, Winter 2013
Devellectual
Provided HTML file for psychic control panel
-->
	
	<head>
		<title>Psychic Showdown</title>
		<!--<link rel="stylesheet" href="controlpanel.css"></link>-->
	</head>

	<body>
		<div class="container-fluid">
			<div class="hero-unit"><h1><img id="logo" src="logo.gif" alt="Clairvoyance"/></h1></div>

			<div class="navbar navbar-fixed-top">
		      <div class="navbar-inner">
		        <div class="container-fluid">
		          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="brand" href="#">Clairvoyance</a>
		          <div class="nav-collapse collapse">
		            <p class="navbar-text pull-right">
						<a href="#" class="btn navbar-link">Hello, <i class="icon-user"></i>mamafong<span class="text-success">(81)</span></a>
						<a href="logout.php"><button class="btn btn-mini btn-primary" type="button">Sign Out</button></a>
		            </p>
		            <ul class="nav">
		              <li><a href="dashboard.php">Dashboard</a></li>
		              <li><a href="controlpanel.php">Control Panel</a></li>
		              <li class="active"><a href="#">Game</a></li>
		            </ul>
		          </div>
		        </div>
		      </div>
		    </div>
		    
		    <div class="row-fluid">
		    	<!-- 
		    		Awesome Game!
		    			1) Ten Rounds 
		    			 ) Get two random fortunes
		    			 ) Select Winner
		    			 ) Animate Defeat
		    			2) Leader Board Button

		    	-->
			</div>

		</div>

		<script type="text/javascript">
  			var uvOptions = {};
  			(function() {
    		var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    		uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/HapdJfpfqiotNI1efoDQtQ.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  			})();
		</script>
	</body>
		    
