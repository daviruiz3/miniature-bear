
$(document).ready(function() {
	$(window).hashchange(navigate);
	$('#blah').click(hijack);
});

function navigate() {
	$('#content').load(window.location.hash); // inject contact.html into #content
}

function hijack(event) {
	event.preventDefault(); // prevent browser from navigating to page
	window.location.hash = '#!/pagethree.html'; // “navigate” to hash-fragment instead
}