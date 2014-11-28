<?php
	require_once("top.php");
	require_once("shared.php");
	require_once("twitteroauth/twitteroauth.php");
	echo "page loaded" . "</br></br>";
	//$iv = hash('sha256', 'tacos');
		#var_dump($iv);
	//echo $iv . "<br/>";
	
	//app key and secret set
	$consumerkey = "1mz2PD1opSIENGdGf0xyA";
	$consumersecret = "unYMt2ZoLgxAYT8zLvA9cBmUseU96EfkLYOK7PpxQQ";
	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	$url2= "https://api.twitter.com/1.1/statuses/home_timeline.json";
	$verifyurl = "https://api.twitter.com/1.1/account/verify_credentials.json";
	//find last time a fortune was applied to the wall of each user
	
	//set parameters for ClairvoyanceAp
	$catoken = '1257869977-rjxexzbvOavLMvrshTmW5PNzuz2LHvKZ7N3nfFc';
	$casecret = 'QsxxBKxkPdYke514JE0DuDAhLpnSEe0xsno87X8W0aQ';
	$catwitter = new TwitterOAuth($consumerkey, $consumersecret, $catoken, $casecret);
	
	
	//set the latest id, defaults to known id
	$latestid = '310925967466037251';
	$idquery = "select twitterid from tweetidstorage";
	if($st = $con->prepare($idquery)){
		$st->execute();
		$st->bind_result($tid);
		while($row = $st->fetch()){
			$latestid = $tid;
		}
		$st->close();
	}else{
		echo $con->error;
	}
	
	echo 'latest id: ' . $latestid . '</br>';
	
	/*$file = fopen("test.txt","w");
	fwrite($file, "THIS IS A STRING");
	fclose($file);*/
	
	//$result = $twitter->get($url, array('screen_name' => 'ClairvoyanceAp'));
	$result = $catwitter->get($url2, array('since_id' => $latestid));
	$newid = $result[0]->id;
	$queryl = 'UPDATE fortuneList SET likes = likes + 1 WHERE id = ?';
	$queryd = 'UPDATE fortuneList SET dislikes = dislikes + 1 WHERE id = ?';
	
	echo $newid . '</br></br>';
	
	function databasewrite(){

	}
	
	for($i = 0, $size = count($result); $i < $size; ++$i) {
		//echo $result[$i]->in_reply_to_status_id . "</br>";
		//echo $result[$i]->id . "</br>";
		
		//echo $result[$i]->in_reply_to_status_id . "</br>";
		//echo $result[$i]->in_reply_to_screen_name. "</br>";
		$replyto = $result[$i]->in_reply_to_status_id;
		
		if(!is_null($replyto)){
			echo $result[$i]->text . "</br>";
			$replyparts = explode(' ', $result[$i]->text);
			if($replyparts[0] == '@ClairvoyanceAp'){
				//echo 'this is a like or dislike </br>';
				$qr = "select id from fortuneList where fortune_twitter_id = ?";
				$flid = null;
				echo 'test';
				if($statement = $con->prepare($qr)){
					echo 'test2';
					$statement->bind_param("s", $replyto);
					echo 'test3';
					$statement->execute();
					echo 'test4';
					$statement->bind_result($fortunelistid);
					echo 'test4';
					while($row = $statement->fetch()){
						echo 'test5';
						$flid = $fortunelistid;
					}
					echo 'test6';
					$statement->close();
				}else{
					echo $con->error;
				}
				echo 'test7';
				if(strtolower($replyparts[1]) == 'like'){
					echo 'this is a like</br>';
					if($stmt = $con->prepare($queryl)){
						$stmt->bind_param("s", $flid);
						$stmt->execute();
						$stmt->close();
						echo "ran";
					}else{
						echo $con->error;
					}
				}else if(strtolower($replyparts[1]) == 'dislike'){
					echo 'this is a dislike</br>';
					if($stmt = $con->prepare($queryd)){
						$stmt->bind_param("s", $flid);
						$stmt->execute();
						$stmt->close();
						echo "ran";
					}else{
						echo $con->error;
					}
				}else{
					echo 'this is some stupid reply a person made</br>';
				}
			}else{
				echo 'this is a reply to a tweet but not a like or dislike</br>';
			}
		}else{
			echo 'this is not in reply to a tweet</br>';
		}
		
	}
	
	if(!is_null($newid)){
		$idquery = "REPLACE INTO tweetidstorage ( id, twitterid) VALUES ( 1, ?)";
		if($st = $con->prepare($idquery)){
			$st->bind_param("s", $newid);
			$st->execute();
			$st->close();
		}else{
			echo $con->error;
		}
	}
	echo '<pre>';
	print_r($result);
	echo "</pre>";
	
	
	//TODO list
	/*
		//get latest tweets from homepage: DONE
		//find out if they are replies: DONE
		find out if they are like or dislike: DONE
		incriment like or dislike in corresponding fortuneList entry: DONE
		save id of most recent tweet gathered: DONE
		
		clean up test code: IP
			
			
				
	*/
	
?>

	</body>
</html>