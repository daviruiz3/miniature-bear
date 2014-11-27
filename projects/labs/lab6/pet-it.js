// pet-it.js
// Skeleton JavaScript file for Lab 6: Pet-It
// INFO 343, Autumn 2012
var INDEX=1;
var PETARRAY;
// When the page is ready, attach event handlers
$(document).ready(function() {
	$("#dogs, #cats").change(getBreeds);
	$("#next").click(nextClick);
});

function inje(data){
	$('#description').html(data);
}

function injectSnippet(data){
	//alert("Dog or Cat");
	PETARRAY = data.split('\n');
	var list = $('<ul>');
	$.each(PETARRAY, function(index, value){
		//alert(index + " " + value);
		var item = $('<li>').text(value);
		list.append(item);
	});
	$('#breeds nav').html(list);
	var altDesc = PETARRAY[0];
	var firstPet = PETARRAY[0].toLowerCase().replace(" ", "_");
	$('#pet').attr({'src': "breeds/"+firstPet+".jpg", 'alt': altDesc});
	$.ajax("breeds/"+firstPet+".html",{
		success: inje
	});
}

// Get the list of all breeds of cats/dogs using Ajax.
function getBreeds() {
	var value = $(this).attr('id');
	if(value == 'dogs') {
		//alert("Doggity dog");
		$.ajax('dogs.txt',{
			success: injectSnippet
		});
	}else{ 
		$.ajax('cats.txt',{
			success: injectSnippet
		});
		
		//alert("Catty Catzersons");
	}
}

// Move to next breed.
function nextClick() {
	if (INDEX == PETARRAY.length){ 
		$('li:nth-child('+INDEX+')').removeClass('selected');
		INDEX = 0;
	}

	//alert("next " +PETARRAY[INDEX]);
	
	var altDesc = PETARRAY[INDEX];
	var firstPet = PETARRAY[INDEX].toLowerCase().replace(" ", "_");
	$('#pet').attr({'src': "breeds/"+firstPet+".jpg", 'alt': altDesc});
	$.ajax("breeds/"+firstPet+".html",{
		success: inje
	});
	$('li:nth-child('+INDEX+')').removeClass('selected');

	$('li:nth-child('+(INDEX+1)+')').addClass('selected');
	
	INDEX = INDEX + 1;
	
}



// Provided Ajax error code.
function ajaxError(xhr, type, error) {
	alert("Error making Ajax request!\n\n" + 
		"Status code: " + xhr.status + "\n" +
		"Status text: " + error + "\n\n" + 
		"Full text of response:\n" + xhr.responseText);
}
