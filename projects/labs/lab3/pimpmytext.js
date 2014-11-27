function bp(){
	var t = document.getElementById("stuff")
	t.style.fontSize ="24pt";
}

function bl(){
	var c = document.getElementById("Bling")
	var t = document.getElementById("stuff")
	
	if(c.checked){	
		t.style.fontWeight ="bold";
		t.style.color = "green";
		t.style.textDecoration="underline blink";
	}else{
		t.style.fontWeight="normal";
		t.style.color = "black";
		t.style.textDecoration ="none";
	}
}

function sn(){
	var t = document.getElementById("stuff")
	t.innerHTML =toUpperCase(t.innerHTML)
}