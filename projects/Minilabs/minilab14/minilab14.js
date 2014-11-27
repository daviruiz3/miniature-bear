// Mini-lab 13: Twitter Search
// INFO 343 Autumn 2012
// Morgan Doocy

var CENTER = {
	lat: 18.21521200,
	lng: -95.84004300
}

var MAP;

function createMarker(loc, contents, tooltip) {
	var marker = new google.maps.Marker({
		position: loc,
		map: MAP,
		title: tooltip
	});
	
	var infowindow = new google.maps.InfoWindow({
		content: contents
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(MAP,marker);
	});
}

//Google map example function
function initializeMap() {
	// an object that we'll use to specify options
	var micasa = new google.maps.LatLng(CENTER.lat, CENTER.lng);
	var mapOptions = {
		center: micasa, //change this
		zoom: 16, // change this 
		mapTypeId: google.maps.MapTypeId.SATELLITE // change this
	};
	
	// the DOM object we're going to put the map into
	var mapElement = document.getElementById("map_container");

	// create the map inside mapElement with options specified by mapOptions
	MAP = new google.maps.Map(mapElement, mapOptions);
	
	var $para = $('<p>').text("I miss my home.");	
	
	createMarker(micasa, $para[0], "Bienvenidos!");
}

// Handle clicking on the 'fetch' button. (Fetch tweets.)
function fetchClick() {
	var qu = $("#query").val();
	
	//alert(quer);
	$.ajax('http://search.twitter.com/search.json', {
		dataType: 'jsonp',
		data:{ 
				q : qu,
				geocode : 47.669044 + "," + -122.331505 + ",2mi" 
			  },
		success: injectTweets
	});
}

function injectTweets(data) {
	$('#output').empty();
	
	console.log(data.results);
	var $alarma = "No Data";
	$.each(data.results, function(i, tweet) {
		//do something with this tweet
		var listitem = $('<li>');
		var $pone = $('<p>').text(tweet.from_user);
		var $ptwo = $('<p>').text(tweet.text);	
		var $pic = $('<img>').attr({'src': tweet.profile_image_url, 'alt':tweet.from_user_name});
		
		if (tweet.geo !== null) {
			$alarma = "("+ tweet.geo.coordinates[0]+", "+tweet.geo.coordinates[1]+")";
			var loc = new google.maps.LatLng(tweet.geo.coordinates[0], tweet.geo.coordinates[1]);
			createMarker(loc, $ptwo[0], $alarma); 
		}
		
		listitem.append($pone).append($ptwo).append($pic).append($alarma);
		$('#output').append(listitem);
	});
	
	alert("Search for '"+data.query+"' completed in "+ data.completed_in);
}



// Provided Ajax error handler function (displays useful debugging information).
function ajaxError(jqxhr, type, error) {
	var msg = "An Ajax error occurred!\n\n";
	if (type == 'error') {
		if (jqxhr.readyState == 0) {
		msg += "Looks like the browser security-blocked the request.";
		} else {
		msg += 'Error code: ' + jqxhr.status + "\n" + 'Error text: ' + error + "\n" +
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

// When the document's ready, attach a click handler to the 'fetch' button.
function load(){
	$('#fetch').click(fetchClick);
	initializeMap(); //initializes the mappers!
}

$(document).ready(load);