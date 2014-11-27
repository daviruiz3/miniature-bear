// Calculate and display swatches for at least three 
// additional colors (i.e., four total) which harmonize 
// with the entered color. These can be lighter/darker 
// variants, colors at various angles around the color circle, etc.

//mono
//triad
//tetrad
//quad
//sext
$(document).ready(function(){
	var colorPicker = $.farbtastic("#colorpicker");
	colorPicker.linkTo(pickerUpdate);
	$("#red,#green,#blue").slider({
		orientation:"horizontal",
		range:"min",
		max:255,
		slide:sliderUpdate
	});
	function sliderUpdate() {
		var red=$("#red").slider("value");
		var green=$("#green").slider("value");
		var blue=$("#blue").slider("value");
		var hex=hexFromRGB(red,green,blue);
		colorPicker.setColor("#"+hex);
	}	
	function hexFromRGB(r,g,b){
		var hex = [r.toString(16),g.toString(16),b.toString(16)];
		$.each(hex,function(nr,val){
			if(val.length===1){
				hex[nr]="0"+val;
			}
		});
		return hex.join("").toUpperCase();
	}
	function pickerUpdate(color){
		$("#swatch").css("background-color",color);
		if(colorPicker.hsl[2]>0.5){
			$("#innerswatch").css("color","#000000");     
		}
		else{
			$("#innerswatch").css("color","#ffffff");   
		}
		$("#innerswatch").html(color.toUpperCase())
		var red = parseInt(color.substring(1,3),16);
		var green = parseInt(color.substring(3,5),16);
		var blue = parseInt(color.substring(5,7),16);	
		$("#red").slider("value",red);
		$("#green").slider("value",green);
		$("#blue").slider("value",blue);		
	}
});
