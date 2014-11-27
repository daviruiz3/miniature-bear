/***************
**David R.******
**Info 343B*****
**Oct 19, 2012**
***minilab6.js***
****************/
var cdId;

function pageLoad(){
	//alert("No seas un Cabron!");

	$("#begin").on("click", function(){
		cdId=setInterval(countDownByOne, 1000);
	});
	
}

function end(){
	alert("This is the End");
}

function a(){
	setInterval(countDownByOne,1000);
}

function countDownByOne(){
	var g = $("#seconds").val();
	if(g <= 0){
		clearInterval(cdId);
		end();
	}
	else{	
		$("#seconds").val(g-2);
		c();
	}
}

function c(){
	//$("div").css({"left":$l,"top":$t});
	//var $d = $('<div class="box">').text('A Div Box!').appendTo('body');
	alert("count");
	rb();
}

function rb(){
	var $l = Math.random()* (window.innerWidth-50);
	var $t = Math.random()* (window.innerHeight-50);
	var hue = 'rgb(' + (Math.floor((256*Math.random()))) + ','+ (Math.floor((256*Math.random()))) + ','+ (Math.floor((256*Math.random()))) + ')';
	var $d = $('<div class="box">').css({"border":"2px solid green","width":"50px","height":"50px","left":$l,"top":$t, "position":"absolute", "background-color": hue}).appendTo("body");
	$(".box").click(function(){$(this).remove()});
}


$(document).ready(pageLoad);