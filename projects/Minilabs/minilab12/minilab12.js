// Mini-lab 12: AJAX + XML
// INFO 343 Autumn 2012
// Morgan Doocy

// Mini-Lab 12: AJAX + XML
// INFO 343 Autumn 2012
// David N. Ruiz

// When the document's ready, attach a click handler to the 'fetch' button.
$(document).ready(function() {
	$('#fetch').click(fetchClick);
});

// Handle clicking on the 'fetch' button. (Make Ajax request.)
function fetchClick() {
	//alert("Watup!");
	
	// Make AJAX request for snippet.xml here!
	$.ajax("snippet.xml", {
		success: runXML
	});
}

function runXML(data){
	//alert(data);
	// get all bar elements and create an li tage for eah of them and inject it into the page
	var $xml = $(data);
	var	$bar = $xml.find("bar");
	
	alert($bar);
	//alert($bar);
	/* 	var bar = data.getElementsByTagName("bar");
	var ullist = $('#output');*/
	// $.each($bar, function(index, value) {
		// alert(value);
		// var item = $('<li>').text(value.text());
		// ullist.append(item);
	// }); 
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
