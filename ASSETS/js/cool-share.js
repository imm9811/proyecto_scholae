$(function (){

	var url = 'http://tutorialzine.com/2014/08/cool-share-jquery-plugin/';

	var options = {

		twitter: {
			text: 'Check out this awesome jQuery Social Buttons Plugin! ',
			via: 'Tutorialzine'
		},
		facebook: true,
		googlePlus : false,
		whatsApp:true
	};

	$('.socialShare').shareButtons(url, options);
});