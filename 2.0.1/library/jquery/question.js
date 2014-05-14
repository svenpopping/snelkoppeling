$(document).ready(function() {
	function reColor() {
		var width = $('div.progress-bar__container span.progress').data('width');
			
			/*Percentage van de balk wordt verdeeld in vier stukken*/
			var r,g,b;
			if(width <= 33) {
				var relWidth = width; //Relatieve breedte wordt genomen en hieruit wordt de huidige kleur berekend.
				
				r = 52 + (-.49 * relWidth);
				g = 152 + (.33 * relWidth);
				b = 219 + (-4.15 * relWidth);
			}
			else if (width <= 66) {
				var relWidth = width - 33;

				r = 36 + (6.64 * relWidth);
				g = 163 + (1.42 * relWidth);
				b = 82 + (-1.64 * relWidth);
			}
			else if (width <= 99) {
				var relWidth = width - 66;
				
				r = 255 + (-1.15 * relWidth);
				g = 210 + (-5.12 * relWidth);
				b = 28 + (.06 * relWidth);
			}
			else {
				r = 217;
				g = 41;
				b = 30;
			}
			
			var rgb = 'rgb(' + Math.round(r) + ', ' + Math.round(g) + ', ' + Math.round(b) + ')'; //Kleur wordt afgerond op hele getallen.
			$('div.progress-bar__container span.progress').css("background-color", rgb);
	}

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	}

	function isAlreadyUsed(check) {
		var username = check.toLowerCase();
		var isAlreadyUsed = null;

		var jqxhr = $.getJSON("http://localhost/snelkoppeling/2.0.1/library/json/username.json.php", function(json) {
	 		$.each(json.results,function(i,result){
	 			var used = result.id;
	 			if(username == used){
	 				isAlreadyUsed = true;
	 				return false;
	 			} else {
	 				isAlreadyUsed = false;
	 			}
	 		});
	 		console.log(isAlreadyUsed);
		});

		//return isAlreadyUsed;
	}

	$('fieldset input.required').focusout( function() {
		if (!$(this).val()) {
			$(this).parent().children('span#empty-error').removeClass('hidden');
		} else if ($(this).val()) {
			$(this).parent().children('span#empty-error').addClass('hidden');
		}
	});

	$('fieldset input#email').focusout( function() {
		var email = $(this).val();
		if ($(this).val()) {
			if(!isValidEmailAddress(email)) { 
				$(this).parent().children('span#email-error').removeClass('hidden');
			} else {
				$(this).parent().children('span#email-error').addClass('hidden');
			}
		} else {
			$(this).parent().children('span#email-error').addClass('hidden');
		}
	});

	$('fieldset input#hwachtwoord').focusout( function() {
		if ($(this).val()) {
			var pass = $('fieldset input#wachtwoord').val();
			var hpass = $(this).val();
			if(pass != hpass){
				$(this).parent().children('span#pass-error').removeClass('hidden');
			} else {
				$(this).parent().children('span#pass-error').addClass('hidden');
			}
		} else {
			$(this).parent().children('span#pass-error').addClass('hidden');
		}
	});

	$('fieldset input#username').focusout( function() {
		var username = $(this).val();
		console.log(isAlreadyUsed(username) + " error");
		// if(isAlreadyUsed(username)){
		// 	console.log("")
		// 	$(this).parent().children('span#user-error').removeClass('hidden');
		// 	return false;
		// } else {
		// 	$(this).parent().children('span#user-error').addClass('hidden');
		// }
		// $.getJSON("//localhost/snelkoppeling/2.0.1/library/json/username.json.php", function(json) {
	 // 		$.each(json.results,function(i,result){
	 // 			var used = result.id;
	 // 			if(username == used){
		// 			$(this).parent().children('span#user-error').removeClass('hidden');
		// 			return false;
	 // 			} else {
	 // 				$(this).parent().children('span#user-error').removeClass('hidden');
	 // 			}
	 // 		});
		// });
	});	

	slider = $('.bxslider').bxSlider({
		adaptiveHeight: true,
		infiniteLoop: false,
		pager: false,
		nextText: 'Volgende',
		prevText: 'Vorige',
		nextSelector: $("fieldset.prev-next ul li.next"),
		prevSelector: $("fieldset.prev-next ul li.prev"),
		onSlideNext: function(slideElement, oldIndex, newIndex) {
			if(oldIndex == 0) {
				if ($('input#name').val() 
						&& $('input#username').val() 
						&& $('input#email').val()
						&& $('input#wachtwoord').val()
						&& $('input#hwachtwoord').val()
						&& ($('input#wachtwoord').val() == $('input#hwachtwoord').val())
						&& isValidEmailAddress($('input#email').val())
					) {
					return;
				} else {
					slideElement.goToSlide(0);
				}
			} else if (oldIndex == 11) {
				$('fieldset.prev-next ul li.next a').hide();
			}
		},
		onSlidePrev: function(slideElement, oldIndex, newIndex) {
			if(newIndex == 12) {
				$('fieldset.prev-next u li.next a').fadeIn();
			}
		}
	});

	$("fieldset ul li.next a").addClass("button");
	$("fieldset ul li.prev a").addClass("button");

	$("fieldset ul li.next").click(function() {
		if($("div.progress-bar__container span.progress").width() < 440) {
			$("div.progress-bar__container span.progress").css("width", "+=36.7px");
			$("div.progress-bar__container span.progress").data('width', ($("div.progress-bar__container span.progress").width()/440)*100);

			reColor();
		}
	});

	$("fieldset ul li.prev").click(function() {
		if($("div.progress-bar__container span.progress").width() > 37) {
			$("div.progress-bar__container span.progress").css("width", "-=36.7px");
			$("div.progress-bar__container span.progress").data('width', ($("div.progress-bar__container span.progress").width()/440)*100);

			reColor();
		}
	});

	// $('form.questions-form').submit(function( event ) {
	// 	if ($('input#day').val() && $('select#month').val() != '0' && $('input#year').val()) {
	// 		return;
	// 	}
	// 	$('fieldset ul li input').addClass('error');
	// 	event.preventDefault();
	// });
});	