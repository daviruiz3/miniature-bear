// Mini-lab 10: AJAX
// INFO 343 Autumn 2012
// Morgan Doocy

/*alert("Hello");
// Handle clicking on the 'fetch' button

*/
//function ajaxError()

function injectSnippet(data) {
	//$('#output').html(data);
	var sniparray = data.split('\n');
	alert(sniparray);
	var ullist = $('<ul>');
	$.each(sniparray, function(index, value){
		var item = $('<li>').text(value);
		ullist.append(item);
	});
	$('#breeds').append(ullist);
}

function fetchClick() {
	// make AJAX request here!
	//$.ajax('snippet.html', {
	//  success: injectSnippet
	//});
	
	$.ajax('snippet.txt', {
		success: injectSnippet
	});
}

function load(){
	//alert("Hello");
	$('#fetch').click(fetchClick);
}

$(document).ready(load);