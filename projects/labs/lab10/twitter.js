// twitter.js
// JavaScript skeleton file for Lab 10: Mobile Twitter
// INFO 343, Autumn 2012
// Morgan Doocy



// Make all ajax requests on the page call ajaxError in case of error.
$.ajaxSetup({ error: ajaxError });

// Capture the submit event on the search form.
$(document).ready(function() {
	$('#search-form').submit(search);
});

// Call pageChange when currently-displayed internal "page" is about to be changed.
$(document).bind("pagebeforechange", pageChange);


function injectTweets(data){
	//alert("Succesful Tweet Request");
	$('#results').empty();
	$('#results').listview('refresh');

	$.each(data.results, function(i, tweet) {
		//do something with this tweet
		var listitem = $('<li>');
		
		var atimeline = $('<a href="#show-timeline">');
		var $pic = $('<img>').attr({'src': tweet.profile_image_url.replace('_normal', '_bigger'), 'alt':tweet.from_user_name});
		
		var $smallhead = $('<small>').text('@' + tweet.from_user);
		var $userhead = $('<h3>').text(tweet.from_user);
		$userhead.append($smallhead);

		var $ptweet = $('<p>').text(tweet.text);	
		
		atimeline.append($pic).append($userhead).append($ptweet);
		
		listitem.append(atimeline);
		
		$('#results').append(listitem);
	});
}

// A search term was entered into the search box.
function search(event) {
	// Prevent the browser from submitting the form.
	event.preventDefault();
	event.stopPropagation();
	
	// Your code here! (Make an Ajax request to for search results.)
	var qu = $("#search").val();

	$.ajax('http://search.twitter.com/search.json', {
		dataType: 'jsonp',
		data:{ q : qu },
		success: injectTweets
	});
}

// When the subpage is about to be changed, determine which page is about to be
// shown so that loading/cleanup of #show-timeline can be performed.
function pageChange(event, data) {
	// console.log(data);
	if (typeof data.toPage === "string") {
		var to = $.mobile.path.parseUrl(data.toPage);
		var timeline = /^#show-timeline/;
		var search = /^(#search-page|)$/;
		
		if (to.hash.search(search) !== -1) {
			// We're moving back to the search page. Clear out the profile info
			// on #show-timeline.
			clearProfile();
		} else if (to.hash.search(timeline) !== -1) {
			// We're going to show the timeline. Fetch and inject the profile data
			// into it for the screenname specified in the ?screen_name parameter.
			var screenname = data.options.pageData.screen_name;
			loadProfile(screenname);
		}
	}
}

// Remove any existing profile/timeline information from #show-timeline.
function clearProfile() {
	$('#avatar').removeAttr('src').removeAttr('alt');
	$('#show-timeline header h1').empty();
	$('#show-timeline header h2').empty();
	$('#user_tweets strong').empty();
	$('#user_following strong').empty();
	$('#user_followers strong').empty();
	$('#user_location strong').empty();
	$('#timeline').empty();
}

// Load the profile/timeline data for the screenname specified.
function loadProfile(screenname) {
	// Your code here!
}

// Provided Ajax error handler function. (Displays useful debugging message.)
function ajaxError(jqxhr, type, error) {
	var msg = "An Ajax error occurred!\n\n";
	if (type == 'error') {
		if (jqxhr.readyState == 0) {
			// Request was never made - security block?
			msg += "Looks like the browser security-blocked the request.";
		} else {
			// Probably an HTTP error.
			msg += 'Error code: ' + jqxhr.status + "\n" + 
			       'Error text: ' + error + "\n" + 
			       'Full content of response: \n\n' + jqxhr.responseText;
		}
	} else {
		msg += 'Error type: ' + type;
		if (error != "") {
			msg += "\nError text: " + error;
		}
	}
	alert(msg);
}