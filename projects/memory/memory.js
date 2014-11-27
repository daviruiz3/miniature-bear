// memory.js
// Skeleton JavaScript file for HW4: Memory
// INFO 343, Autumn 2012
// Morgan Doocy

// URL of the image for the back of each card.
var BACK_IMAGE = 'http://students.washington.edu/daviruiz/skull.jpg';

// URLs and alt texts of the images to be used for card fronts.
var FRONT_IMAGES = {
	'http://umbra.nascom.nasa.gov/images/latest_aia_193_tn.gif':                                      'Green',
	'http://www.teemingbrain.com/wp-content/uploads/2012/09/fiber_optics_and_circuit_board.jpg':      'Fiber Optics',
	'http://umbra.nascom.nasa.gov/images/latest_aia_171.gif':                                         'Blue',
	'http://cdn.zmescience.com/wp-content/uploads/2012/06/quantum-computers.jpg':                     'Quantum',
	'http://umbra.nascom.nasa.gov/images/latest_aia_304.gif':                                         'Orange',
	'http://info343.ischool.uw.edu/homework/4/hongkong.jpg':                                          'Hong Kong',
	'http://th09.deviantart.net/fs10/150/i/2006/090/7/c/Circuit_Board_by_Animorphza.png':             'Circuit',
	'http://blog.swagbucks.com/wp-content/uploads/2011/04/SwagCodeExtravaganza-150x150.jpg':          'Code',
	'http://readwrite.com/files/files/files/hack/quality_code_matrix.jpg':                            'Matrix'
};

// Make a list of available spaces.
var SPACES = [];
var ROWS = 3, COLS = 6;
for (var i = 0; i < ROWS; i++) {
	for (var j = 0; j < COLS; j++) {
		SPACES.push({ row: i, col: j });
	}
}

// memory.js
// HW#4 Memory
// INFO 343B 2012
// David N. Ruiz

var FACE1; // First card
var FACE2; // Second card
var COUNT = 0; // Random wiggle counter
var CLICKCOUNT = 0; // Click counter

//creates deck of the cards
function createDeck(){
	"use strict";
	// Traverses through loop and adds a card to a randomly selected space
	$.each(FRONT_IMAGES, function(index){
		
		var random= Math.floor(Math.random() * SPACES.length); // Random index
		var spc = SPACES[random]; // Chosen index space
		
		SPACES.splice(random, 1); // Delete index space chosen
		
		// Card and images added to board
		var $card = $('<div class="card">').appendTo('#board');		
		$('<img class="front">').attr({'src': index, 'alt': FRONT_IMAGES[index]}).appendTo($card);
		$('<img class="back">').attr({'src': BACK_IMAGE, 'alt':'Back'}).appendTo($card);
		
		
		// Cards placed on board with animation and a random wiggle and a random drop.
		// wiggle handles margin while drop handles placement
		var randomWiggle = Math.floor(Math.random() * 10);
		var randomDropT = Math.floor(Math.random() * 5);
		var randomDropL = Math.floor(Math.random() * 5);
		//top=row left=col
		if(COUNT%2===0){
			$card.animate({left: 0, top:0}).animate({left: spc.col * (175 + randomDropL), top: (175 - randomDropT)*spc.row, margin: randomWiggle}).delay(250);
			//$card.css({'top':spc.row * (175 - randomDrop),'left':spc.col * (175 + randomDrop),'margin': randomWiggle});
		}else{
			$card.animate({left: 0, top:0}).animate({left: spc.col * (175 - randomDropL), top: (175 + randomDropT)*spc.row, margin: randomWiggle}).delay(250);
			//$card.css({'top':spc.row * (175 + randomDrop),'left':spc.col * (175 - randomDrop),'margin': randomWiggle});
		}
		COUNT = COUNT + 1;
	});
}

// Function flip rotates the cards
function flip(){
	$(this).addClass('rotate');
	
	// On first click value is set
	if(FACE1 === null && CLICKCOUNT === 0){
		FACE1 = $(this);
		CLICKCOUNT = CLICKCOUNT + 1;
	}else{
	// On more than one click value is either checked or reset
		if(CLICKCOUNT === 1){
			FACE2 = $(this);
			setTimeout(checkCards, 1000);

		}else{
			//alert("Stop freaking clicking!");
			$('.card').removeClass('rotate');
			FACE1= null;
			FACE2= null;

		}
		CLICKCOUNT = 0;
	}
}

// Function checkCards handles the comparison
function checkCards(){
	"use strict";
	// Compares card but also makes sure it is not the same card
	if(FACE1.children('.front').attr('alt') === FACE2.children('.front').attr('alt') && FACE1[0]!== FACE2[0]){		
		
		//animates image only
		FACE1.children('img').slideUp(270).delay(1110).fadeIn(270);
		FACE2.children('img').slideUp(270).delay(1110).fadeIn(270);
		
		//animates but mainly removes the element
		FACE1.hide(250, function () {$(this).remove();});
		FACE2.hide(250, function () {$(this).remove();});


	}else{
		FACE1.removeClass('rotate');
		FACE2.removeClass('rotate');
	}
	FACE1 = null;
	FACE2 = null;
}


// Function "load" creates two Deck and begins the waits for user to click
function load() {
	"use strict";
	
	//Uggh couldn't figure out the dynamic part
	//createDeck();
	//createDeck();
	//$('#board').css('height', 1000);
	
	createDeck();
	createDeck();
	$('.card').click(flip);
}

$(document).ready(load);