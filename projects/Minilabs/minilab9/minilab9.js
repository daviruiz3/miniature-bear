//David N Ruiz
// minilab9.js
// 10- 28- 2012
function yourEmail(){
	$('<p>').text($(this).val()).appendTo('#stuff');
}
function phone(){
	$('<p>').text($(this).val()).appendTo('#stuff');
}
function search(){
	$('<p>').text($(this).val()).appendTo('#stuff');
}
function dateChosen(){
	$('<p>').text($(this).val()).appendTo('#stuff');
}

function load() {
	$( "#draggable" ).draggable();
	$( "input[type='email']").change(yourEmail);
	$( "input[type='tel']").change(phone);
	$( "input[type='search']").change(search);
	$( "input[type='date']").change(dateChosen);
}

$(document).ready(load);