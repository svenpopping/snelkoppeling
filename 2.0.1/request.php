<?php
	require_once("_header.php");
	require_once("functions.php");

	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";
?>

	
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
<script type="text/javascript">

$(document).ready(function () {
	var age = "<?= $_REQUEST['age'] ?>";
	var state = "<?= $_REQUEST['state']; ?>";
	var orientation = "<?= $_REQUEST['orientation']; ?>";
	var gender = "<?= $_REQUEST['gender']; ?>";
	var name = "<?= $_REQUEST['name']; ?>";
	var email = "<?= $_REQUEST['email']; ?>";
	var user = "<?= $_REQUEST['user']; ?>";
	var password = "<?= sha1($_REQUEST['wachtwoord']); ?>";
	var hpassword = "<?= sha1($_REQUEST['hwachtwoord']); ?>";
	var ip = "<?= $_REQUEST['ip']; ?>";
	var id = '';

	if(age && state && orientation && gender && name && email && user && password && hpassword && ip && (password == hpassword)) {
		addPercentage(60);
		$.ajax({
			type: "POST",
			url: "http://localhost/snelkoppeling/2.0.1/scripts/saves_personal_info.php",
			data: { age: age, state: state, orientation: orientation, gender: gender, name: name, email: email, user: user, password: password, ip: ip}
		}).done(function(text) {
			addPercentage(100);
			id = text;
			var allInfo = '{ "result" : [';
			for (var i = 1; i <= 20; i++) { 
				allInfo += $('input#info-' + i).val() + ',';
			}
			allInfo = allInfo.substring(0, allInfo.length - 1);
			allInfo += ']}';

			$.ajax({
				type: "POST",
				url: "http://localhost/snelkoppeling/2.0.1/scripts/saves_answers_info.php",
				data: { id: id, result: allInfo }
			}).done(function() {
				addPercentage(150);
				$.ajax({
					type: "GET",
					url: "http://localhost/snelkoppeling/2.0.1/scripts/calculate_matches.php",
					data: { person_id: id }
				}).done(function() {
					addPercentage(258);
					setTimeout(function(){return true;}, 2000);
					window.location.href = 'http://localhost/snelkoppeling/2.0.1/user_profile/';
				});
			});
		});
	}
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

	function addPercentage(addPercentage) {
		for (var i = 0; i < addPercentage; i++) {
			loadingGif();
			setTimeout(function(){return true;}, 5);
		};
	}

	function loadingGif() {
		if(($("div.progress-bar__container span.progress").width() + 1) < 570) {
			$("div.progress-bar__container span.progress").css("width", "+=1px");
		} else {
			$("div.progress-bar__container span.progress").css("width", "1px");
		}
		$("div.progress-bar__container span.progress").data('width', ($("div.progress-bar__container span.progress").width()/570) * 100);
		reColor();
	}
});	
</script>

<div class="status_info">
	<center>
		<h3>Op dit moment worden jouw matches berekend</h3>
		<p class="lead">Soms kan het berekenen van de matches even duren, wacht a.u.b. rustig af en vernieuw de pagina niet. Dit zorgt er namelijk voor dat uw gegevens niet worden opgeslagen. </p>
	
		<div class="progress-bar__container" style="margin: 50px auto 10px;">
			<span class="progress" style="width: 1px" data-width="1"></span>
		</div>

		<h2>!! Vernieuw de pagina NIET !!</h2>
	</center>
</div>
	

<?php
	for ($i = 1; $i <= 20; $i++) {
		$string = ""; $desired = "";
		if(isset($_REQUEST['desired-answer-'.$i])) {
			foreach ($_REQUEST['desired-answer-'.$i] as $key => $value) {
				$desired .= $value.",";
			}
		} else {
			$desired = "0,";
		}
		$desired = substr($desired, 0, -1);

		$answer = (isset($_REQUEST['answer-'.$i])) ? $_REQUEST['answer-'.$i] : 0;
		$importance = (isset($_REQUEST['importance-'.$i])) ? $_REQUEST['importance-'.$i] : 0;

		$string = '{"answer": '.$answer.', "array": [ '.$desired.' ], "importance": '.$importance.' }';
		?>
			<input type="hidden" id="<?= 'info-'.$i ?>" value='<?= $string ?>' >
		<?php
	}
	require_once("_footer.php");
?>