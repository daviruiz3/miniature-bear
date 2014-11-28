var round = '0';

$(window).load(function() {
	//$('.controls input').change(validateForm);
	$('#unsubscribe').bind("click", submit);
});

function submit(){
	//alert($(this).attr("href"));
	
	$.get('unsubscribehelper.php', 
		{functionName : 'test', inputvar:$(this).attr("href")},
		function(data) {
			//alert("anything else");
			//alert(data);
			location.href = "logout.php";
		});

    return false;
}