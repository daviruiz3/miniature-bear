function pageLoad() {
	$('.shareSelector').socialShare({
		animation: 'launchpad',
		social: 'facebook,twitter,google,linkedin',
		whenSelect: true,
		selectContainer: '.shareSelector',
		blur: true
	});

	$('.followSelector').socialProfiles({
		animation: 'launchpadReverse',
		blur: true,
		//facebook: 'davinruizromero',
		google: '107830164945272143276',
		twitter: 'daviruizt',
		linkedin: 'www.linkedin.com/pub/david-ruiz/61/355/6b5'
	});
}

$(document).ready(pageLoad);