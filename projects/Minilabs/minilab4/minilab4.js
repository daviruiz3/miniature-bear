/*************
**David Ruiz**
**Info 343B***
**minilab js**
**Oct 9, 2012*
**************
*/

alert("Firefox is Awesome!")

function fox() {
	alert("I said Firefox is Awesome!");
	alert("Don't ask me again!");
	var img = document.getElementById("pic");
	img.src = "http://rlv.zcache.com/totally_freakin_awesome_trucker_hat-p148400611528870129bfsbr_400.jpg";
	img.alt = "Totally Freakin Awesome!"
}

function comment() {
	var span = document.getElementById("oldcomment");
	var textbox = document.getElementById("comment");
	var temp = span.innerHTML;
	span.innerHTML = span.innerHTML + textbox.value;
	textbox.value = temp;
}