/*
	David Ruiz, Jonathan Wai
	11/5/12
	INFO 343 B
	colorpicker.js
	Javascript coding for a webpage to match given functionality specifications.
*/


// Calls functions based on radio choice selected
function selectColorType(){

	var $check = $('[name=cc]:checked').val();// value selected	
	
 	if($check == "RGB"){
		colorRGB();
	} else if ($check == "HEX"){
		colorHex();
	} else if($check == "HSL"){
		colorHSL();
	}else{
		//do nothing
	}
}

// This function sets the color of each rectangle in the header.
function printColors(r, g, b){
	var	master = new Color(r, g, b);
	var comp1 = new Color(g, r, b);
	var comp2 = new Color(b, g, r);
	var cont1 = new Color(g, b, r);
	var cont2 = new Color(b, r, g);
	
	$("#rectangle").empty().css('background-color', master.hex);
	printText($('#rectangle'), master);
	
	$('#comp1').empty().css('background-color', comp1.hex);
	printText($('#comp1'), comp1);
	
	$('#comp2').empty().css('background-color', comp2.hex);
	printText($('#comp2'), comp2);
	
	$('#cont1').empty().css('background-color', cont1.hex);
	printText($('#cont1'), cont1);
	
	$('#cont2').empty().css('background-color', cont2.hex);
	printText($('#cont2'), cont2);
	
	// Changes color based lightness and darkness
	if (parseInt(master.l) < 50){ 
		$('header p').css('color', 'white');
		$('#pageView').css('color', 'white');
	} else { 
		$('header p').css('color', 'black');
		$('#pageView').css('color', 'black');
	}
	
	// Setting colors for the preview page
	$("#pageView").css('background-color', master.hex);
	$('#pageView h4').css('background-color', comp1.hex);
	$('#pageView .column, #pageView .column2').css('border', "5px solid" +master.hex);
	$('#pageView img').css('border', "20px solid" + comp2.hex);
	$('.column').css('background-color', cont1.hex);
	$('.column2').css('background-color', cont2.hex);

}

// This functions prints the appropriate values within the container rectangle passed.
function printText(container, colors){
	var textHex = $('<p>').text("Hex " + colors.hex.toUpperCase());
	var textRGB = $('<p>').text("RGB (" + colors.r + ", " + colors.g + ", "+ colors.b + ")");
	var textHSL = $('<p>').text("HSL (" + Math.round(colors.h) + ", " + Math.round(colors.s) + ", " + Math.round(colors.l) + ")");
	container.append(textHex, textRGB, textHSL);
}

// Sets the colors based on hexadecimal input
function colorHex() {
	
	// Checks to make sure string is an appropriate Hex value 
	if($(".rad input[type='text']").val().length == 6){
		
		// splits string by character and turns capitalizes string.
		var hexValues = $(".rad input[type='text']").val().toUpperCase().split("");
		
		// Traverses array and compares to appropriate hex character.
		// If not vlaid it converts character to zero.
		$.each(hexValues, function(index, value) {
			if(value == '0'|| value == '1'|| value =='2'||value =='3'||
			value =='4'|| value =='5'|| value =='6'|| value =='7'|| value=='8'||
			value =='9'|| value =='A'|| value =='B'|| value =='C'|| value=='D'||
			value =='E'|| value =='F'){ 
			}else{
				hexValues[index] = '0';
			}
		});
	}
	// Takes the appropriately converted hexValue and sends it back to the input.
	// In other words NO SPECIAL CHARACTERS!
	$(".rad input[type='text']").val(hexValues.join(""));
	
	var key = new Color(); // Setting values to RGB
	key.setHex("#"+hexValues.join(""));
	var $r = key.r,
		$g = key.g,
		$b = key.b;
	
	printColors($r, $g, $b); // Call to set and print colors
}

// Sets the RGB colors for the panel view
function colorRGB(){

	var	$r = $("#Rslider").slider("value"),
		$g = $("#Gslider" ).slider("value"),
		$b = $("#Bslider").slider("value");
		
	$('[name=red]').val($r);
	$('[name=green]').val($g);
	$('[name=blue]').val($b); 
	
	printColors($r, $g, $b); // Call to set and print colors
}

function colorHSL(){

	var $h = $("#Hslider").slider("value"),
		$s = $("#Sslider" ).slider("value"),
		$l = $("#Lslider").slider("value");
		
	var key = new Color();
	
	key.setHSL($h, $s, $l); // Setting values to HSL
	var $r = key.r,
	    $g = key.g,
		$b = key.b;
		
	$('[name=hue]').val($h);
	$('[name=saturation]').val($s);
	$('[name=lightness]').val($l);
		
	printColors($r, $g, $b); // Call to set and print colors
}

function display(){
	alert("Display");
}

function pageLoad(){
	$("#Rslider, #Gslider, #Bslider , #Hslider, #Sslider, #Lslider").slider();
	
	$("#pageView").dialog({
            autoOpen: false,
            show: "blind",
            hide: "fade",
			width: '60em',
			zIndex: 99999
    });
 
	$( "#previewPage" ).click(function() {
		$( "#pageView" ).dialog("open");
		return false;
	});
	
	$("[name=cc]").change(selectColorType);
	
	$("[name=red], [name=blue], [name=green]").bind('input', colorRGB);
	
	$("#Rslider, #Gslider, #Bslider").slider({
		range: "min",
		max: 255,
		value: 128,
		slide: selectColorType
	});
	
	$("#Hslider").slider({
		range: "min",
		max: 360,
		value: 180,
		slide: selectColorType
	}); 
	
	$("#Sslider, #Lslider").slider({
		range: "min",
		max: 100,
		value: 50,
		slide: selectColorType
	});
	
	$("[name=hex]").bind('input', selectColorType);
	$("[name=hue]").bind('input', selectColorType);
	$("[name=saturation]").bind('input', selectColorType);
	$("[name=lightness]").bind('input', selectColorType);
}

$(document).ready(pageLoad);