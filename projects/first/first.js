var canvas_matrix = document.getElementById("rain_matrix");

var c_m = canvas_matrix.getContext("2d");

// Making the canvas full screen
// 10 cells wide and 22 high
canvas_matrix.height = 440;
canvas_matrix.width = 200;

var english = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z 1 2 3 4 5 6 7 8 9 0 ! @ # $ % ^ & * ( ) _ + - = , . / < > ? ` ~ ";
var binary = "1 0"
var hex = "00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F 10 11 12 13 14 15 16 17 18 19 1A 1B 1C 1D 1E 1F 7F"

languages = [english, binary, hex];
language = languages[Math.floor(Math.random()*languages.length)].split(" ");

var font_size = 20;
// # of rain columns
var columns = canvas_matrix.width/font_size; //font_size;

var drops =[];

// x below is the x coordinate
// 1 = y coordinate of the drop(same for every drop initially)
for(var x = 0; x < columns; x++)
	drops[x] = 1;

// drawing the characters
function draw(){
	//Black BG for the canvas
	//translucent BG to show trail
	c_m.fillStyle = "rgba(0, 0, 0, 0.05)";
	c_m.fillRect(0, 0 , canvas_matrix.width, canvas_matrix.height);

	c_m.fillStyle = "#0F0"; //green text
	c_m.font = font_size + "px courier";

	//looping over drops
	for(var i=0; i<drops.length; i++){
		//a random character
		var text= language[Math.floor(Math.random()*language.length)];

		//x = i*font_size, y = value of drops[i]*font_size
		c_m.fillText(text, i*font_size, drops[i]*font_size);

		//sending the drop back to the top randomly after it has crossed the screen
		//adding a randomness to the reset to make the drops scattered on the Y axis
		if(drops[i]*font_size > canvas_matrix.height && Math.random() > .975)
			drops[i] = 0;

		drops[i]++;
	}

}

setInterval(draw, 33);


