/***************
**David R*******
**Oct 19 2012***
**Info 343B*****
****Lab 4*******
*****maze.js****
****************/

var win = true;

function  pageLoad(){
	alert("Hello GangSTAR!");
	$(".boundary:not(.example)").mouseover(turnRed);
	$("#end").mouseover(wl);
	$("#start").click(r);
	$("#maze").mouseleave(turnRed);
}

function turnRed(){
		$(".boundary:not(.example)").css('background-color','red');
		$("#maze").css('border','4px solid red');
		win=false;
}

function turnGray(){
		$(".boundary:not(.example)").css('background-color','#EEE');
		$("#maze").css('border', 'none');
}

function wl(){
	if(win){
		$("#status").text("You win! :]");
		$("#maze").css('border','4px solid green');
		//alert("You win! :]");
	}else{
		$("#status").text("Sorry, you lost. :[");
		//alert("Sorry, you lost. :[");
	}
}

function r(){
	turnGray();
	win = true;
	var h = Math.round(Math.random()*150);
	$(".boundary:not(.example)").css({"height": h, "border": "1px solid black","overflow":"hidden"});
	$("#status").text("Move your mouse over the \"S\" to begin.");
}

$(document).ready(pageLoad);