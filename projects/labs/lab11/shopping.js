// shopping.js
// JavaScript skeleton for Lab 11: Shopping Cart
// INFO 343, Autumn 2012
// Morgan Doocy

// Make all Ajax requests on the page call ajaxError in case of error.

//alert("Linked to JS!");

$.ajaxSetup({ error: ajaxError });

$(document).ready(function() {
	//alert("Works on load!");
	$('#update').click(updateCart);
});

function addProducts(data){
	alert("Succesful Find");
	
	$.each(data, function(index,value){
			alert(value);
	});
}

function updateCart(){
	//alert("Watup!");
	$.ajax('products.json', {
		dataType: json,
		success: addProducts,
		error: ajaxError
	});
	
}

// Provided function to create and return a table row (as a jQuery object).
function row(cols) {
	var $tr = $('<tr>');
	$.each(cols, function (cls, content) {
		var $td = $('<td>', { 'class': cls }).html(content);
		$tr.append($td);
	});
	return $tr;
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