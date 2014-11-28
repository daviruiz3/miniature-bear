<?php
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
<<<<<<< HEAD
	/*$result = $con->query("REPLACE INTO student (id, username, oauthtoken, oauthsecret, subscribeDate, terminationDate, status)
							VALUES ('" . $access_token['user_id'] . "','" . $access_token['screen_name'] . "',
							'" . $access_token['oauth_token'] . "',
							'" .$access_token['oauth_token_secret'] . "', 
							NOW(), NULL, 1)");
	*/	
	$statement = $con->prepare("REPLACE INTO student (id, username, oauthtoken, oauthsecret, subscribeDate, terminationDate, status)
							VALUES ('" . $access_token['user_id'] . "','" . $access_token['screen_name'] . "',
							'" . $access_token['oauth_token'] . "',
							'" .$access_token['oauth_token_secret'] . "', 
							NOW(), NULL, 1)");
	$statement->bind_param("ssssss", $fname, $lname, $uname, $email, $pw);
	$statement->execute();
	/*
	mysqli_query($con, "REPLACE INTO student (id, username, oauthtoken, oauthsecret, subscribeDate, terminationDate, status)
						VALUES ('" . $access_token['user_id'] . "','" . $access_token['screen_name'] . "',
						'" . $access_token['oauth_token'] . "',
						'" .$access_token['oauth_token_secret'] . "', 
						NOW(), NULL, 1)");
	*/
=======

>>>>>>> aa4b7c1d184f84144f6b47170ab8beb327cd75c9
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