// David N. Ruiz
// INFO 343 Lab#7
// 11-10-2012

// ajax error modified to insert a user friendly message in results
// the alert still functions the same I felt like it would be better that way
function ajaxError(jqxhr, type, error) {
  var msg = "An Ajax error occurred!\n\n";
  if (type == 'error') {
    if (jqxhr.readyState == 0) {
      // Request was never made - security block?
      msg += "Looks like the browser security-blocked the request.";
    } else {
		// Probably an HTTP error.
		if(jqxhr.status == 404){
			var comment = "Word was not found in the page.";
			$('#result').empty();
			$('#result').append(comment);
		}else{
			msg += 'Error code: ' + jqxhr.status + "\n" + 
				'Error text: ' + error + "\n" + 
				'Full content of response: \n\n' + jqxhr.responseText;
		}
    }
  } else {
    msg += 'Error type: ' + type;
    if (error != "") {
      msg += "\nError text: " + error;
    }
  }
  alert(msg);
}

// accepts the data returned and creates a list with the definition, example and permalink
function runJSON(data){
	// alert(data[0].definition+ " "+data[0].example+" "+ data[0].permalink);
	// var def = $('<p>').text(data[0].definition);
	// var ex = $('<p class="example">').text(data[0].example);
	// var p = $('<p>')
	// var a = $('<a>').attr('href', data[0].permalink).text('permalink');
	// p.append(a);
	// $('#result').append(def).append(ex).append(p);
	$('#result').empty();
	list = $('<ol>');
	$.each(data, function(index, value){
		//alert(value.definition+ " "+ value.example+ " "+ value.permalink);
		var listitem = $('<li>');
		var def = $('<p>').text(value.definition);
		var ex = $('<p class="example">').text(value.example);
		var p = $('<p>')
		var a = $('<a>').attr('href', value.permalink).text('permalink');
		p.append(a);
		listitem.append(def).append(ex).append(p);
		list.append(listitem);
	});
	$('#result').append(list);
	
	//$('#result').append(ex);
	//$('#result').append(a);
}

// makes a request to the api for the word that was chosen
function lookupClick(){

	var value = $('#term').val();
	
	// $.get("https://info343.ischool.uw.edu/labs/7/urban.php?term=API&format=json", function(data) { 
		// runJSON(data);
	// });

	// I finally get this now!
	$.ajax("https://info343.ischool.uw.edu/labs/7/urban.php?term=API&format=json", {
		data: {term: value},
		success: runJSON,
		error: ajaxError
	})
}

// loads page when it is ready
function load(){
	//alert("Hello!");
	$('#lookup').click(lookupClick);
}

$(document).ready(load);