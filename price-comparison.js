jQuery(document).ready(function() {

});

jQuery(document).on('click', '.configure-price-comparison', function(e) {
	var url = jQuery(e).parent().parent().find('input[type=text]').first().attr('href');
	console.log(url);
	console.log(e);
});