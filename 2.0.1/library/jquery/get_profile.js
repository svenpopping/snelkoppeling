$(document).ready(function() {
	$('.about_yourself_save').hide();
	
	$('.about_yourself').click(function() {
		$( this ).replaceWith( "<textarea class='about_yourself_textarea' style='width: 100%; display: inline-block;'>" + $( this ).text() + "</textarea>" );
		$('.about_yourself_save').fadeIn();
	});

	$('.about_yourself_save').click(function() {
		console.log('Save...');

		$('.about_yourself_textarea').replaceWith( "<dd class='about_yourself'>" + $('.about_yourself_textarea').text() + "</dd>" );
		$('.about_yourself_save').hide();

		event.preventDefault();
	});
});