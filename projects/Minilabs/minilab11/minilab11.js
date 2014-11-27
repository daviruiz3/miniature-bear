//ajax error
function ajaxError(jqxhr, type, error) {
  var msg = "An Ajax error occurred!\n\n";
  if (type == 'error') {
    if (jqxhr.readyState == 0) {
      // Request was never made - security block?
      msg += "Looks like the browser security-blocked the request.";
    } else {
      // Probably an HTTP error.
      msg += 'Error code: ' + jqxhr.status + "\n" + 
             'Error text: ' + error + "\n" + 
             'Full content of response: \n\n' + jqxhr.responseText;
    }
  } else {
    msg += 'Error type: ' + type;
    if (error != "") {
      msg += "\nError text: " + error;
    }
  }
  alert(msg);
}

function awesome(data){
	
	alert(data.length);
	var allImages = $('#output');
	//var imageTag = $('<img>');
	$.each(data, function(index, value){
		//alert(index+" "+value.caption+" "+value.file);
		var pic = $('<img>').attr({'src': value.file, 'alt': value.caption});
		//count = count + 1;
		//var item = $('<li>').text(value);
		allImages.append(pic);
	});
}

function fetch(){
	//alert("Fetchy Fetch")
	$.get('images.json', function(data){
		awesome(data);
	});

}

function load(){
	$("#fetch").click(fetch);
}


$(document).ready(load);