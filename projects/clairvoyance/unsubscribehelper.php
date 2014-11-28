<?php
	require_once('twitteroauth/twitteroauth.php');
	require_once("shared.php");
	$twitterid;
	if(isset($_REQUEST['inputvar'])){
		$twitterid = $_REQUEST['inputvar'];
	}
	
	
	$query = 'select oauthtoken, oauthsecret from student where id = ?';
	$usertoken;
	$usersecret;
	if($statement = $con->prepare($query)){
		$statement->bind_param("s", $twitterid);
		$statement->execute();
		$statement->bind_result($oauth, $secret);
		while($row = $statement->fetch()){
			$usertoken = $oauth;
			$usersecret = $secret;
		}
		$statement->close();
	}
	
	
	$consumerkey = "1mz2PD1opSIENGdGf0xyA";
	$consumersecret = "unYMt2ZoLgxAYT8zLvA9cBmUseU96EfkLYOK7PpxQQ";
	//set parameters to tweet to vincet509
	//$usertoken = '1199015150-aSCwBdNxSxEZ7lVHdHiSzR94K5rm508Paxk2YCU';
	//$usersecret = 'bv15dUsNZVRpEpUccHjlZAdErfMcRQRCvWdLXFPU';
	
	$twitter = new TwitterOAuth($consumerkey, $consumersecret, $usertoken, $usersecret);
	$verifyurl = "https://api.twitter.com/1.1/account/verify_credentials.json";
	$unsubscribeurl = "https://api.twitter.com/1.1/friendships/destroy.json";
	$postparams = array("screen_name" => "ClairvoyanceAp");
	$result = $twitter->post($unsubscribeurl, $postparams);
	
	//update user statuses to mark invalid users
	$setinactive = "UPDATE student SET status = 0, terminationDate = SYSDATE() WHERE id = ?";
	echo $twitterid;
	if($inactiveprep = $con->prepare($setinactive)){
		$inactiveprep->bind_param('s', $twitterid);
		echo $inactiveprep->execute();
		echo 'saved';
		//$inactiveprep->close();
	}else{
		echo $con->error;
		//echo '</br> QUERY WAS NOT PREPARED--------------------------------------------------';
	}
	//echo 'COMMUNIST';
	print_r($result);
	
?>