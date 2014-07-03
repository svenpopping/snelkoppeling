$(document).ready(function (){ 
	slider = $('.bxslider').bxSlider({
		adaptiveHeight: true,
		infiniteLoop: false,
		pager: false,
		nextText: 'Volgende',
		prevText: 'Vorige',
		nextSelector: $("fieldset.prev-next ul li.next"),
		prevSelector: $("fieldset.prev-next ul li.prev")
	});

	$('dt.name a').click(function() {
		console.log($(this).data('href'));
		$("#columns__profile").load($(this).data('href'), function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});
		$("#columns__matches").load("http:<?= $main_path ?>user_profile/message/", function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});
		$('a.back').fadeIn();
	});

	$('a.back').click(function() {
		$("#columns__profile").load("http:<?= $main_path ?>user_profile/get_profile.php", function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});

		$("#columns__matches").load("http:<?= $main_path ?>user_profile/get_matches.php", function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});

		$('a.back').hide();
	});

	$('.progress').each(function( index ) {
		var width = $(this).data('width');
		
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
		
		$(this).css("background-color", rgb); //Kleur wordt als background-color mee gegeven aan de pagina.
	});
}); 
