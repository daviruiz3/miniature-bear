$(window).load(function() {
	$('.controls input').change(validateForm);
	$('#psychform').submit(function(e){
		//alert("it worked");
		e.preventDefault();
		//ajaxCall();
		ajaxCall();
		return false;
	});
	$('#clear').bind("click", clearform);
});

//need to connect to database... pass ajaxdata to webservice or something that can connect to DB
//
function ajaxCall() {
	//alert("ajaxCall");
	dataString = $('#psychform').serialize();
	$.post("psychicregisterhelper.php", dataString,
        function(data){
            if(data.email_check == 'invalid'){
                    $("#errors").html("<div class='errorMessage'>Sorry " + data.firstName + ", " + data.email + " is NOT a valid e-mail address. Try again.</div>");
            } else {
                $("#errors").html("<div class='successMessage'>" + data.email + " is a valid e-mail address. Thank you, " + data.firstName + ".</div>");
            }
			console.log(data.insertResult);
        }, "json").fail(function() {alert("FAILURE!")});
}

function validateForm() {
	console.log("entering validateForm() function");
	var fName = $('#firstName').val();
	var lName = $('#lastName').val();
	var user = $('#userName').val();
	var email = $('#inputEmail').val();
	var pass = $('#pass').val();
	var cPass = $('#confirmPass').val();
	
	if (fName != "" && lName != "" && user != "" && email != "" && pass != "" && cPass != "") {	
		var namePatt = /^[a-zA-Z]+$/g;
		if (!namePatt.test(fName) && fName != "") {
			console.log("invalid first name");
			//print invalid first name or last name
			var div = document.createElement("div");
			div.innerHTML = "Invalid first name.";
			var errors = document.getElementById('errors');
			div.setAttribute("id", "errorfName");
			errors.appendChild(div);
		} else {
			if ($('#errorfName').length != 0) {
				$('#errorfName').remove();
			}
		}

		if (!namePatt.test(lName) && lName != "") {
			console.log("invalid last name");
			//print invalid first name or last name
			var div = document.createElement("div");
			div.innerHTML = "Invalid last name.";
			var errors = document.getElementById('errors');
			div.setAttribute("id", "errorlName");
			errors.appendChild(div);
		} else {
			if ($('#errorlName').length != 0) {
				$('#errorlName').remove();
			}
		}
		
		var emailPatt = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if (!emailPatt.test(email) && email != "") {
			console.log("invalid email");
			var div = document.createElement("div");
			div.innerHTML = "Invalid Email.";
			var errors = document.getElementById('errors');
			errors.appendChild(div);		
		}
		
		/*
		if (pass.length == 0 || cPass.length == 0) {
			console.log("mismatch passwords");
			//print passwords do not match
			var div = document.createElement("div");
			div.innerHTML = "Passwords do not match.";
			var errors = document.getElementById('errors');
			errors.appendChild(div);
		}
		*/
		
		if (pass != cPass) {
			console.log("mismatch passwords");
			//print passwords do not match
			var div = document.createElement("div");
			div.innerHTML = "Passwords do not match.";
			var errors = document.getElementById('errors');
			errors.appendChild(div);
		}
	}
	
}

function clearform() {
	$('.controls input').innerHTML = "";
	$('#errors').innerHTML = "";
}