/*************
***David R.***
***Info 343B**
*Oct 19, 2012*
*minilab7.js**
**************
*************/
function load(){
	//alert("This works now!")
	$("div").mouseover(a);
	$("div").click(r);
}

function a(){
	//alert("Now this works!");
	var $l = Math.random()* window.innerWidth;
	var $t = Math.random()* window.innerHeight;
	$("div").css({"left":$l,"top":$t});
	//alert("completed!");

}

function r(){
	var $cho = Math.round(Math.random()*6);
	if($cho == 1){
		$("div").css({"transform":"rotate(721deg)"});
	}else if($cho == 2){
		$("div").css({"transform":"rotate(721deg)"});
		$("div").hide();
	}else if($cho ==3){
		$("div").css({"transform":"rotate(721deg)"});
		$("div").fadeOut();
	}else if($cho == 4){
		$("div").css({"transform":"rotate(721deg)"});
		$("div").slideDown();
	}else if($cho ==5){
		$("div").css({"transform":"rotate(721deg)"});
		$("div").toggle();
	}else if($cho == 6){
		$("div").css({"transform":"rotate(721deg)"});
		$("div").fadeToggle();
	}else{
		$("div").css({"transform":"rotate(721deg)"});
		$("div").slideToggle();
	}
}

$(document).ready(load);