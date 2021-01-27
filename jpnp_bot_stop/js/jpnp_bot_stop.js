/*
jpnp_bot_stop plugin
*/

jQuery(function($){

	$('.botstop-form-group').hide(); // hide inputs from users

	var code = $('.botstop-form-group-code span:first').text();
	$('.botstop-form-group-code input').val( code ); // answer the captcha instead of the user

});