// Mini-lab 13: Twitter Search
// INFO 343 Autumn 2012
// Morgan Doocy

// When the document's ready, attach a click handler to the 'fetch' button.
$(document).ready(function() {
	$('#fetch').click(fetchClick);
	initializeMap(); //initializes the mappers!
});

//Google map example function
function initializeMap() {
	// an object that we'll use to specify options
	var micasa = new google.maps.LatLng(18.2167, -95.8333);
	var mapOptions = {
		center: micasa, //change this
		zoom: 16, // change this 
		mapTypeId: google.maps.MapTypeId.SATELLITE // change this
	};
	
	// the DOM object we're going to put the map into
	var mapElement = document.getElementById("map_container");

	// create the map inside mapElement with options specified by mapOptions
	var map = new google.maps.Map(mapElement, mapOptions);

	var marker = new google.maps.Marker({
		position: micasa,
		map: map,
		title: "Bienvenidos!"
	});

	var contentString = "<h2> Mata De Cana, Veracruz -- Mexico</h2>"+
		"<p>I miss my home I wish I could go back but the violence has gotten worse"+
		" hopefully I will be able to return soon.</p>"
	
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});
}

// Handle clicking on the 'fetch' button. (Fetch tweets.)
function fetchClick() {
	var q = $("#query").val();
	
	//alert(quer);
	$.ajax('http://search.twitter.com/search.json', {
		dataType: 'jsonp',
		data:{ q : $('#query').val()},
		success: injectTweets
	});
}

function injectTweets(data) {
	$('#output').empty();
	alert("Search for '"+data.query+"' completed in "+ data.completed_in);
	
	$.each(data.results, function(i, tweet) {
		//do something with this tweet
		var listitem = $('<li>');
		var pone = $('<p>').text(tweet.from_user);
		var ptwo = $('<p>').text(tweet.text);
		var pic = $('<img>').attr({'src': tweet.profile_image_url, 'alt':tweet.from_user_name});
		//alert(tweet.from_user+" "+tweet.text+" "+tweet.profile_image_url);
	 	listitem.append(pone).append(ptwo).append(pic);
		$('#output').append(listitem);
	});
}



// Provided Ajax error handler function (displays useful debugging information).
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
