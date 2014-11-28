<?php
error_reporting(E_ALL);
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */
	require_once("shared.php");
 
/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. 
   * $access_token = array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham")
   * this is storing the array in the sessino variable access_token
   * instead we want to seperate this out and put it into the db
   * see viewfortunes.php to see how to do a query
*/
$_SESSION['access_token'] = $access_token;
	/*$result = $con->query("REPLACE INTO student (id, username, oauthtoken, oauthsecret, subscribeDate, terminationDate, status)
							VALUES ('" . $access_token['user_id'] . "','" . $access_token['screen_name'] . "',
							'" . $access_token['oauth_token'] . "',
							'" .$access_token['oauth_token_secret'] . "', 
							NOW(), NULL, 1)");
	*/
	$user_id = $access_token['user_id'];
	$screen_name = $access_token['screen_name'];
	$oauth_token = $access_token['oauth_token'];
	$oauth_token_secret = $access_token['oauth_token_secret'];
	
	$query1 = 'select id from student where id = ?';
	$stmt = $con->prepare($query1);
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$stmt->bind_result($user);
	$row = $stmt->fetch();
	$stmt->close();
	
	echo 'test';
	/*$user_id = 54321;
	$screen_name = 'test';
	$oauth_token = 'test';
	$oauth_token_secret = 'test';*/
	
	if(is_null($row)){
		$querya = "INSERT INTO student VALUES ( ?,  ?,  ?,  ?,  SYSDATE(),  NULL,  1)";
		$s = $con->prepare($querya);
		$s->bind_param("isss" , $user_id, $screen_name, $oauth_token, $oauth_token_secret);
		$s->execute();
	}else{
		$query = "UPDATE student SET oauthtoken = ?, oauthsecret = ?, subscribeDate = SYSDATE(), terminationDate = NULL, status = 1 where id = ?";
		$statement = $con->prepare($query);
		$statement->bind_param("sss",  $oauth_token, $oauth_token_secret, $user_id);
		$statement->execute();
	}
	
	/*
	mysqli_query($con, "REPLACE INTO student (id, username, oauthtoken, oauthsecret, subscribeDate, terminationDate, status)
						VALUES ('" . $access_token['user_id'] . "','" . $access_token['screen_name'] . "',
						'" . $access_token['oauth_token'] . "',
						'" .$access_token['oauth_token_secret'] . "', 
						NOW(), NULL, 1)");
	*/
	
	//make the user follow the app
	$consumerkey = "1mz2PD1opSIENGdGf0xyA";
	$consumersecret = "unYMt2ZoLgxAYT8zLvA9cBmUseU96EfkLYOK7PpxQQ";
	$posttester = new TwitterOAuth($consumerkey, $consumersecret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$getparams =  array("screen_name" => 'ClairvoyanceAp', "follow" => 'true');
	$postresult = $posttester->post('https://api.twitter.com/1.1/friendships/create.json', $getparams);
	
	//make app follow the user (or this will quickly become impossible).
	$catoken = '1257869977-rjxexzbvOavLMvrshTmW5PNzuz2LHvKZ7N3nfFc';
	$casecret = 'QsxxBKxkPdYke514JE0DuDAhLpnSEe0xsno87X8W0aQ';
	$caparams =  array("screen_name" => $access_token['screen_name'], "follow" => 'true');
	$caapp = new TwitterOAuth($consumerkey, $consumersecret, $catoken, $casecret);
	
	$caresult = $caapp->post('https://api.twitter.com/1.1/friendships/create.json', $caparams);
	
/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: ./clearsessions.php');
}
