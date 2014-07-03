head.js({site: "//cdn.regner.us/js/load.js"}); //Algemene Javascript bibliotheken worden geladen.


head.ready("plugins", function() { //Wanneer alle plugins geladen zijn de onderstaande code uitvoeren.

	/*Functie die kleurcodes geeft aan de match balk. De kleuren worden "warmer" op naar mate de match hoger wordt*/
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
	
	/*Functie die extra informatie over een match weergeeft wanneer er op de naam van deze match geklikt wordt.*/
	$(".info-matches").hide(); //Bij begin alle extra informatie verhullen.
	$( "dt.name" ).on("click", function( e ) {
		/*Wanneer er op de naam geklikt wordt de informatie naar beneden schuiven.*/
		if($(e.target).parent().children(".matches").children(".info").children(".info-matches").hasClass('done')){
			$(e.target).parent().children(".matches").children(".info").children(".info-matches").slideDown("fast").removeClass('done');
		} 
		/*Wanneer er voor een tweede keer op de naam geklikt wordt de informatie weer verhullen.*/
		else {
			$(e.target).parent().children(".matches").children(".info").children(".info-matches").slideUp("fast").addClass('done');
		}
	});
	
	/*Functie die het mogelijk maakt om een profielfoto te wijzigen op de match pagina. Wanneer er op de link geklikt wordt, wordt er een form weergegeven om een afbeelding te uploaden.*/
	$("a#change-profile-pic").click(function() {
		$("a#change-profile-pic").addClass("hidden");
		$("form#profile-pic-form").removeClass("hidden");
	});
});




/*

Width Totaal: 570px;
Blauw 	RGB (52,152,219)
Groen	RGB (36,163,82)
Geel	RGB (255,210,28)
Rood	RGB (217,41,30)


*/