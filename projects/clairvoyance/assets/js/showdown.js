var round = '0';

$(window).load(function() {
	//$('.controls input').change(validateForm);
	$('#bt1').bind("click", submit);
	$('#bt2').bind("click", submit);
	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) {
		var temp = parts[i].split("=");
		$_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}
	if($_GET['round'] != undefined){
		round = $_GET['round'];
	}
});

function submit(){
	//alert($(this).attr("name"));
	
	$.get('showdownhelper.php', 
		{functionName : 'test', inputvar:$(this).attr("name")},
		function(data) {
			//alert(data);
			if(data === "ran") {
				location.href = "showdown.php?round=" + (parseInt(round) + 1);
			}
		});

    return false;
}