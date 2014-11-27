// lightbox.js
// Skeleton JavaScript file for Lab 5: Lightbox
// INFO 343, Autumn 2012
// Morgan Doocy

var IMAGES = [
	{ file: 'http://info343.ischool.uw.edu/labs/5/avocado.jpg',    caption: 'Avocado' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/beach.jpg',      caption: 'Beach' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/biebs.jpg',      caption: 'Biebs' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/bling.jpg',      caption: 'Bling' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/cat.jpg',        caption: 'Cat' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/dew.jpg',        caption: 'Dew' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/fall.jpg',       caption: 'Fall' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/freeway.jpg',    caption: 'Freeway' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/hongkong.jpg',   caption: 'Hong Kong' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/leaves.jpg',     caption: 'Leaves' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/reflection.jpg', caption: 'Reflection' },
	{ file: 'http://info343.ischool.uw.edu/labs/5/tuners.jpg',     caption: 'Tuners' }
];

// David N. Ruiz
// Info 343 Lab#5
// Oct 27, 2012

//Function was removed and replaced by enlarge
/*
function loadimage(event, index){
	event.preventDefault();
	//this.attr('href', IMAGES[index].file);
	$('<img>').attr({'src': IMAGES[index].file, 'alt':IMAGES[index].caption}).appendTo('#container');

	$('#lightbox').show();
	setNavigation(index);
}
*/


//This function handles keyUp Navigation in the lightBox
function leftRight(event, pidx, nidx){
	//Don't know when to call this?
	//$(document.body).keyup(function(event){leftRight(event, index);});
	
	//alert("Left and Right KEYUP BITCH! " + event.which);
	if(event.which == 37){
		//alert("left "+pidx);
		enlarge(event, pidx);
	}else if(event.which == 39) {
		//alert("right"+nidx);
		enlarge(event,nidx);
	}else if(event.which == 27){
		//alert("esc no index");
		//$('#lightbox').hide();
		$('#lightbox').fadeOut();
	}
}

//This method inserts an image in the lightbox
function enlarge(event, index) {
	event.preventDefault();
	$('<img>').attr({'src': IMAGES[index].file, 'alt':IMAGES[index].caption}).appendTo('#container');

	//$('<img>').attr('src', this.href).appendTo('#container');
	//$('#lightbox').show();
	$('#lightbox').fadeIn();
	
	setNavigation(index);
}

//hides the light box when everything but the image and prev\next links are clicked
function deleteLightBox(event){
	//used this instead
	if(event.target == $('#lightbox')[0]){
		//$('#lightbox').hide();
		$('#lightbox').fadeOut();
	}
	/*Couldn't figure this out
	if(event.target == document.getElementById("#lightbox")){
		alert("lightbox");
	}*/
}

//Stops window scrolling when lightbox is launched
function stopScroll(event){
	event.preventDefault();
}

//sets the navigation and handles clicking function for lightbox 
function setNavigation(index){
	//$('#prev').click(loadimage);
	//$('#next').click(loadimage);
	var prevIndex;
	var nextIndex;
	if(index == 0){
		prevIndex = IMAGES.length-1;
		nextIndex = index + 1;
	}else if(index == IMAGES.length-1){
		prevIndex = index - 1;
		nextIndex = 0;
	}else{
		prevIndex = index - 1;
		nextIndex = index + 1;
	}
	
	$('#prev').unbind();
	$('#prev').attr('href',IMAGES[prevIndex].file).click(function(event) {enlarge(event, prevIndex);});
	
	$('#next').unbind();
	$('#next').attr('href',IMAGES[nextIndex].file).click(function(event) {enlarge(event, nextIndex);});
	
	$(document.body).unbind();
	$(document.body).keyup(function(event){leftRight(event, prevIndex, nextIndex);});
	
	 $(window).scroll(function(event){stopScroll(event);});
	
	$('#lightbox').click(function(event){deleteLightBox(event);});
	
	
}

//Loads the page when its ready and inserts the images into the page
function load() {
	//alert(IMAGES.length);
	$.each(IMAGES, function(index, image) {
		var imageFile = $('<img>').attr({'src': image.file, 'alt': image.caption});
		$('<a>').attr('href', image.file).html(imageFile).appendTo('#gallery').click(function(event) {enlarge(event, index);});
		//$('<a>').attr('href', image.file).html($('<img>').attr({'src': image.file, 'alt': image.caption})).appendTo('#gallery').click(enlarge);
	});
	
	
}

$(document).ready(load);