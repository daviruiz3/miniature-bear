<?php
/* we will call this script to post tweets*/ 
	//$scripts = array(array("type" => "js", "link" => "assets/js/tweetposthelper.js"));
	require_once("top.php");
	require_once("shared.php");
	require_once("twitteroauth/twitteroauth.php");
	echo "page loaded" . "</br></br>";
	
	//app key and secret set
	$consumerkey = "1mz2PD1opSIENGdGf0xyA";
	$consumersecret = "unYMt2ZoLgxAYT8zLvA9cBmUseU96EfkLYOK7PpxQQ";
	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	$verifyurl = "https://api.twitter.com/1.1/account/verify_credentials.json";
	//find last time a fortune was applied to the wall of each user
	
	//set parameters for ClairvoyanceAp
	$catoken = '1257869977-rjxexzbvOavLMvrshTmW5PNzuz2LHvKZ7N3nfFc';
	$casecret = 'QsxxBKxkPdYke514JE0DuDAhLpnSEe0xsno87X8W0aQ';
	
	//set parameters to get tweet from augburto
	//$usertoken = '582965734-pWrXgT4624gqoHUUcwyEcAqgDZsawrnFTUrpLV3V';
	//$usersecret = 'ddUlaVgIiC4pYp1PDFOB6BLUqti2pRAOq5dIzp6uw';
	
	//set parameters to tweet to vincet509
	//$usertoken = '1199015150-aSCwBdNxSxEZ7lVHdHiSzR94K5rm508Paxk2YCU';
	//$usersecret = 'bv15dUsNZVRpEpUccHjlZAdErfMcRQRCvWdLXFPU';
	
	
	
	//USE THIS TO POST TO WALL ----------------------------------------------------------------------------
	//update status post method and parameters
	$tweetposteraccount = new TwitterOAuth($consumerkey, $consumersecret, $catoken, $casecret);
	//$postparams = array("status" => "@vincet509 hey this is a fortune");
	//$postresult = $posttester->post("https://api.twitter.com/1.1/statuses/update.json", $postparams);
	//END OF POST TO WALL SAVE FOR LATER-------------------------------------------------------------------
	
	//RUN QUERY TO GET ALL POSSIBLE FORTUNES---------------------------------------------------------------
	$fortunearr = array();
	$fortuneidarr = array();
	//need to make sure status is 1
	$qr = 'select fortune.id, fortune from fortune join psychic on psychic.id = fortune.psychicid where psychic.status = 1 && fortune.status = 1 && expirationDate > NOW()';
	$fortunearrlength;
	if($getfortunes = $con->prepare($qr)){
		#echo 'test </br>';
		$getfortunes->execute();
		#echo 'test </br>';
		$getfortunes->bind_result($fortuneid, $fortune);
		#echo 'test </br>';
		$i=0;
		while($row = $getfortunes->fetch()){
			$fortunearr[$i] = $fortune;
			$fortuneidarr[$i] = $fortuneid;
			echo count($fortunearr) . ' ' . $fortunearr[$i] . '</br>';
			//echo rand(0, count($fortunearr)-1) . '</br>';
			$i++;
		}
		$selectnum = rand(0, count($fortunearr)-1);
		$fortunearrlength = count($fortunearr)-1;
		echo $fortunearr[$selectnum] . '</br>';
	}
	
	//END OF FORTUNE AQUISITION----------------------------------------------------------------------------
	
	//$getparams =  array("screen_name" => 'ClairvoyanceAp', "follow" => 'true');
	//need to check if can trace to specific fortune
	//$postresult = $posttester->post('https://api.twitter.com/1.1/friendships/create.json', $getparams);
	//$postresult2 = $posttester->get('https://api.twitter.com/1.1/statuses/show.json' ,array('id'=> $postresult[0]->in_reply_to_status_id));
	//print_r($postresult);
	echo  'finished selecting forutnes i think' . '</br>';
	//print_r($postresult2);
	echo '</br></br></br>';
	
	//create array for saving relevant id's
	$idarr = array();
	$inactivearr = array();
	
	//get a list of all users
	$testusernamequery = "SELECT student.id, student.username, MAX(appliedDate), student.status, oauthtoken, oauthsecret FROM student LEFT JOIN fortuneList ON fortuneList.student_id = student.id WHERE status = 1 GROUP BY student.id ORDER BY fortuneList.appliedDate DESC";
	//make sure statement can be prepared, if not send error
	if($statement = $con->prepare($testusernamequery)){
		//make sure that username doesn't already exist
		$statement->execute();
		$statement->bind_result($id, $username, $appDate, $status, $token, $secret);
		while($unique = $statement->fetch()){
			echo $username . '</br>';
			//this is test code--------------------------
			if(is_null($appDate)){
				echo '</br>' . 'no app date' . '</br>';
			}else{
				echo 'Latest Applied Date ' . strtotime($appDate) . '</br>';
				
			}
			//end of test code-----------------------------
			
			//go and verify each person and if verified get their time
			
				
	
				//create oauth object for user
				$params = array("screen_name" => $username, "count" => "1");
				$twitter = new TwitterOAuth($consumerkey, $consumersecret, $token, $secret);
				
				//check for invalid login, look for this:
				//stdClass Object ( [errors] => Array ( [0] => stdClass Object ( [message] => Invalid or expired token [code] => 89 ) ) ) 
				$verify = $twitter->get($verifyurl);

				//debug code (must try this with an invalid profile at some point)
				#print_r($verify);
				#echo "</br> error message " . is_null($verify->errors[0]->message);
				
				//if there is no error message then credentials are valid so go ahead and pull information
				if(is_null($verify->errors[0]->message)){
					//create twitter oauth object in order to make authenticated request
					
					//get latest tweet from twitter
					$response = $twitter->get($url, $params);
					
					//print out response information for debugging
					//DELETE THIS IN PRODUCTION BUILD-------------------------------------------------------------------
					//print_r($response);
					//echo "</br></br>";
					//echo $response[0]->text . "</br>";
					echo $response[0]->created_at . "</br>";
					//echo $response[0]->user->screen_name . "</br>";
					//echo "time test: ";
					//END DELETE----------------------------------------------------------------------------------------
					
					//get the created at string from the twitter response and convert it to a date object
					$datestring = $response[0]->created_at;
					//split the date on spaces
					$datearr = preg_split('/\s+/', $datestring);
					//split the date on :
					$timearr = explode(':', $datearr[3]);
					//twitter gives months in words not numbers so must convert months to numbers
					$months = array('Jan'=>'01','Feb'=>'02', 'Mar'=>'03', 'Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07', 'Aug'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12');
					//YYYYMMDDHHMMSS this is the date format I'm converting to
					$datestring = $datearr[5] . $months[$datearr[1]] . $datearr[2] . $timearr[0] . $timearr[1] . $timearr [2];
					$tweetdate =  strtotime($datestring)-(7*60*60); 
					
					//TEST CODE: DISPLAY SAVED DATE----------------------------------
					echo '</br> Latest Post Date: ' . date('Y-m-d H:i:s', (strtotime($datestring)-(7*60*60))) . '</br>';
					echo "Date of Post:        " . (strtotime($datestring)-(7*60*60)) . '</br>';
					echo 'Latest Applied Date: ' . strtotime($appDate) . '</br>';
					//echo 'Latest Applied Date + 3 min: ' . (strtotime($appDate)) . '</br>';
					echo 'Latest Applied Date: ' . date('Y-m-d H:i:s', strtotime($appDate)) . '</br>';
					//END TEST CODE--------------------------------------------------
					
					//2877068 - applied
					//2474891 - post
					//post < applied
					
					//if no latest application or appliedDate + 3 minutes < latest post date
					if((is_null($appDate) || (strtotime($appDate)) < $tweetdate) && $username != 'ClairvoyanceAp'){
						//post to wall
						echo 'post to wall </br>';
						$selectnum = rand(0, $fortunearrlength);
						echo $fortunearr[$selectnum] . '</br>';
						//for now only do real posts to vincet509
						//if($username == 'vincet509'){
							echo 'test GOT INSIDE OF THE IF STATEMENT';
							//USE THIS TO POST TO WALL ----------------------------------------------------------------------------
							//update status post method and parameters
							//$posttester = new TwitterOAuth($consumerkey, $consumersecret, $token, $secret);
							$status = '@' . $username . ' ' . $fortunearr[$selectnum];// I need to hardcode for testing
							//$status = '@' . $username . ' biiuqhuiasdabifoduisa a taco!';
							$postparams = array("status" => $status);
							$postresult = $tweetposteraccount->post("https://api.twitter.com/1.1/statuses/update.json", $postparams);
							echo '</br></br>';
							print_r($postresult);
							echo '</br></br>';
							//END OF POST TO WALL SAVE FOR LATER-------------------------------------------------------------------
							//if post is successful save to applied fortunes
							if(is_null($postresult->errors)){
								//must save the applied fortuneid, the clientid, and the postid for later saving to database
								$postid = $postresult->id_str;
								//echo $postid;
								$pushstring = $fortuneidarr[$selectnum] . ' ' . $id . ' ' . $postid;
								array_push($idarr, $pushstring);
								//echo 'pushed to array';
							}//end of save to applied fortunes
							
						//}//end of if statement that restricts posting to my test account
						
					}else{
						//mark as inactive
						echo 'inactive </br>';
					}
					echo '</br>';
				}else{
					//the user is not verified so mark them inactive
					echo $id;
					array_push($inactivearr, $id);
				}//end of if for verified users
			
		}//end of while loop that runs through all users
		
		echo "query ran </br>";
	}else{
		echo $con->error;
	}//end of statement to get all active users
	
	//save the applied fortune in the database
	$saveappliedfortunequery = "INSERT INTO fortuneList ( id, appliedDate, likes, fortune_id, student_id, fortune_twitter_id, dislikes) VALUES ( UUID(), NOW(), 0, ?, ?, ?, 0)";
	//make sure statement can be prepared, if not send error
	for($i = 0, $size = count($idarr); $i < $size; ++$i) {
		if($saveappliedfortune = $con->prepare($saveappliedfortunequery)){
			
			echo 'the query was prepared ';
			$temp = explode(' ', $idarr[$i]);
			echo 'the array exploded';
			$saveappliedfortune->bind_param('sss', $temp[0], $temp[1], $temp[2]);
			echo 'the parameters were bound';
			$saveappliedfortune->execute();
			echo 'saved ';
			$saveappliedfortune->close();
		}else{
			echo $con->error;
			echo '</br> QUERY WAS NOT PREPARED--------------------------------------------------';
		}
	}
	
	//update user statuses to mark invalid users
	$setinactive = "UPDATE student SET status = 0, terminationDate = SYSDATE() WHERE id = ?";
	//make sure statement can be prepared, if not send error
	for($i = 0, $size = count($inactivearr); $i < $size; ++$i) {
		if($inactiveprep = $con->prepare($setinactive)){
			
			echo 'the query was prepared ';
			$inactiveprep->bind_param('s', $inactivearr[$i]);
			echo 'the parameters were bound';
			$inactiveprep->execute();
			echo 'saved ';
			$inactiveprep->close();
		}else{
			echo $con->error;
			echo '</br> QUERY WAS NOT PREPARED--------------------------------------------------';
		}
	}

	

	
	
	//PROGRESS REPORT----------------------------------------------------------------------------------------
	//find list of all active users: DONE
		//must get a list of users: DONE
		//verify read write access: DONE
		//find the last time a fortune was applied to their wall: DONE
		//see if their latest post is more recent than that time: DONE
	//apply fortune to active users:DONE
		//select a fortune for each user (random): DONE
			//select fortunes: DONE
			//do random: DONE
		//post fortune to twitter status/update:DONE
		//add fortune and user to fortunelist: DONE
	//update which users are active:DONE
	
	//remember to delete all test code
	//remember to delete single user post restriction (only posts to vincet509 right now)
	
?>			
			
	
	</body>
</html>