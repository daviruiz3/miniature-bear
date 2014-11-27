// Lab #8 
// INFO 343 Autumn 2012
// David Ruiz

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
function injectSearch(){
	alert("Success!");
}


// Handle clicking on the 'fetch' button. (Make Ajax request.)
function fetchClick() {
	// Make AJAX request for images.json here!
	//alert("Hello!");
	
	var q = $("#query").val();
	
	//alert(quer);
	$.ajax('http://www.reddit.com/search.json?/jsonp=?', {
		dataType: 'jsonp',
		data:{ q : $('#query').val()},
		success: injectSearch
	});
}

function load() {
	$('#fetch').click(fetchClick);
}

$(document).ready(load);
