<?php 
	require_once('../_header.php');
	require_once('../../functions.php');
	
	// if ($_SERVER['HTTP_REFERER'] == "http://snelkoppeling.info/"){
	// 	$date = $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day'];		
	// 	$age = abs(strtotime(date('Y-m-d')) - strtotime($date));
	// 	$age = floor($age / (365*60*60*24));
		
	// 	$_SESSION['age'] = $age;
	// 	$_SESSION['orientation'] = $_REQUEST['orientation'];
	// 	$_SESSION['gender'] = $_REQUEST['gender'];
	// }
	// if(isset($_REQUEST['submit_questions'])){
	
	// 	if($_SESSION['age'] != 0 && !empty($_REQUEST['name']) && !empty($_REQUEST['username']) && !empty($_REQUEST['email']) && !empty($_REQUEST['wachtwoord'])){	
	// 		function check($user){
	// 			global $mysqli;
	// 			$db_users = "SELECT username FROM gegevens";
	// 			if(!$result = $mysqli->query($db_users)) {
	// 				trigger_error('Fout in query: '.$mysqli->error);
	// 			} else {
	// 				while($r = $result->fetch_array(MYSQLI_ASSOC)){
	// 					if($r['username'] == $user) {
	// 						return "false";
	// 						break 3;
	// 					}
	// 				}
	// 			}
	// 		}
			
	// 		$check = check($_REQUEST['username']);
	// 		if($check != "false"){
	// 			$mysqli->query("INSERT INTO gegevens (
	// 								age,
	// 								sexse,
	// 								gender,
	// 								state,
	// 								name,
	// 								email,
	// 								username,
	// 								password,
	// 								ip
	// 							 ) VALUES (
	// 								'".clean($_SESSION['age'])."', 
	// 								'".clean($_SESSION['orientation'])."',
	// 								'".clean($_SESSION['gender'])."',
	// 								'".clean($_REQUEST['state'])."',
	// 								'".clean($_REQUEST['name'])."',
	// 								'".clean($_REQUEST['email'])."',
	// 								'".clean($_REQUEST['username'])."',
	// 								'".sha1($_REQUEST['wachtwoord'])."',
	// 								'".$_SERVER['REMOTE_ADDR']."')
	// 						") or die($mysqli->error);
							
	// 			$sql_id = "SELECT 
	// 							id 
	// 					   FROM 
	// 					   		gegevens
	// 					   WHERE 
	// 					   		name ='".$_REQUEST['name']."'
	// 					   AND 
	// 					   		email ='".$_REQUEST['email']."'
	// 					   AND 
	// 					   		username = '".$_REQUEST['username']."'
	// 					   AND 
	// 					   		password = '".sha1($_REQUEST['wachtwoord'])."'";
	// 			if(!$result = $mysqli->query($sql_id)) {
	// 				trigger_error('Fout in query: '.$mysqli->error);
	// 			} else {
	// 				$r = $result->fetch_array(MYSQLI_ASSOC);
	// 				$person_id = $r['id'];
	// 				for ($t = 1; $t <= 20; $t++) {
	// 					$ans = (!isset($_REQUEST['answer-'.$t]))? "0": ($_REQUEST['answer-'.$t]+1);
	// 					$imp = (!isset($_REQUEST['importance-'.$t]))? "0": ($_REQUEST['importance-'.$t]+1);
						
	// 					$mysqli->query("INSERT INTO answers (person_id, ans, quest) VALUE (".$person_id.", ".$ans.", ".$t.")");
	// 					if(!empty($_REQUEST['desired-answer-'.$t])){
	// 						foreach ($_REQUEST['desired-answer-'.$t] as $key => $des_ans) {
	// 							$mysqli->query("INSERT INTO desired (person_id, ans, quest) VALUE (".$person_id.", ".($des_ans + 1).", ".$t.")");
	// 						}
	// 					}
	// 					$mysqli->query("INSERT INTO importance (person_id, imp, quest) VALUE (".$person_id.", ".$imp.", ".$t.")");
	// 				}
	// 			}
	// 			$path = "server/_/original/";
	// 			$types = array("image/bmp","image/gif","image/jpeg","image/png");	
	// 			$target = "server/_/original/".basename($_FILES['profielfoto']['name']);
				
	// 			if(move_uploaded_file($_FILES['profielfoto']['tmp_name'], $target)) {
	// 				$nname = random();
	// 				$path_parts = pathinfo($target);
	// 				rename($target, ("server/_/original/".$nname.".".$path_parts['extension']));
					
	// 				$picture = $nname.".".$path_parts['extension'];
	// 				$mysqli->query("UPDATE gegevens SET picture='".$picture."' WHERE id='".$person_id."'") or die($mysqli->error);
	// 			}
	// 			$redir = "?id=".urlencode($person_id);
	// 			header("Location: match.php".$redir);
	// 		} else {
	// 			echo '<div role="alert" class="info">
	// 				<strong>Let op!</strong><small>De door u ingevulde gebruiksnaam is al een keer gebruikt.</small>
	// 			</div><br />'; 
	// 		}
	// 	} else {
	// 		echo '<div role="alert" class="info">
	// 			<strong>Let op!</strong><small>U hebt niet alle verplichte velden invuld. Vul deze in en probeer het opnieuw.</small>
	// 		</div><br />'; 
	// 	}
	// }
?>

<script type="text/javascript">
head.ready(function() {
	function isValidEmailAddress(emailAddress) {
	    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	    return pattern.test(emailAddress);
	};
	$('.close').click(function() {
		$('div.alert-message').fadeOut('slow');
	});
	$('#submit').click(function() {
		var fields = $('input.required').size();
		var wrong = $('input.error').size();
		var error = fields - wrong;
		if(error != fields){
			if($('input.required').val() == this.defaultValue) {
				$('input.required').addClass('error');
			}
			$('html, body').animate({scrollTop:0}, 'slow');
			return false;
		}
	});
	$('input#username').blur(function() {
		var username = $(this).val().toLowerCase();
		$.getJSON("username.json.php", function(json) {
	 		$.each(json.results,function(i,result){
	 			var used = result.id;
	 			if(username == used){
						$('input#username').addClass('error');
						$('p#user-error').removeClass('hidden');
						return false;
	 			} else {
	 				$('input#username').removeClass('error');
	 				$('p#user-error').addClass('hidden');
	 			}
	 		});
		});
	});	
	$('input.required').blur(function() {
	   	if (this.value == this.defaultValue){ 
	   		$(this).addClass('error');
	   	}
	   	return false;
	});
	$('input.required').focus(function() {
	   	$(this).removeClass('error');
	   	return false;
	});
	$('input#email').blur(function() {
		var email = $(this).val();
		if(!isValidEmailAddress(email)) { 
			$(this).addClass('error');
			$('p#email-error').removeClass('hidden');
		} else {
			$(this).removeClass('error');
			$('p#email-error').addClass('hidden');
		}
	});
	$('input#hwachtwoord').blur(function() {
		var pass = $('input#wachtwoord').val();
		var hpass = $(this).val();
		if(pass != hpass){
			$('input#wachtwoord').addClass('error');
			$(this).addClass('error');
			$('p#pass-error').removeClass('hidden');
		} else {
			$('input#wachtwoord').removeClass('error');
			$(this).removeClass('error');
			$('p#pass-error').addClass('hidden');
		}
	});
	
});
</script>

<form enctype="multipart/form-data" action="" method="POST" class="questions-form">
						
	<h2>Persoonsgegevens</h2>
						
	<fieldset>
		<label for="name">Voor- en Achternaam*</label>
		<input type="text" id="name" class="required" name="name" placeholder="Doutzen Kroes" />
	</fieldset>
	
	<fieldset id="username">
		<label for="username">Gebruikersnaam*</label>
		<input type="text" id="username" class="required" name="username" placeholder="doutzen"/>
		<p class="form-help hidden" id="user-error">Gebruikersnaam al in gebruik.</p>
	</fieldset>
	
	<fieldset>
		<label for="email">Email*</label>
		<input type="email" id="email" class="required" name="email" placeholder="hello@me.com"/>
		<p class="form-help hidden" id="email-error">Geen geldig e-mailadres.</p>
	</fieldset>
	
	<fieldset>
		<label for="wachtwoord">Wachtwoord*</label>
		<input type="password" id="wachtwoord" class="required" name="wachtwoord" placeholder="Wachtwoord"/>
	</fieldset>
	
	<fieldset>
		<label for="hwachtwoord">Herhaal wachtwoord*</label>
		<input type="password" id="hwachtwoord" class="required" name="hwachtwoord" placeholder="Herhaal wachtwoord"/>
		<p class="form-help hidden" id="pass-error">Wachtwoorden komen niet overeen.</p>
	</fieldset>
	
	<fieldset>
		<label for="profielfoto">Profielfoto</label>
		<input type="file" id="profielfoto" name="profielfoto" />
	</fieldset>
	
	<fieldset>
		<label for="state">Provincie*</label>
		<select name="state" id="state">
			<option value="0">Friesland</option>
			<option value="1">Groningen</option>
			<option value="2">Drenthe</option>
			<option value="3">Noord-Holland</option>
			<option value="4">Flevoland</option>
			<option value="5">Overijssel</option>
			<option value="6">Gelderland</option>
			<option value="7">Utrecht</option>
			<option value="8">Zuid-holland</option>
			<option value="9">Zeeland</option>
			<option value="10">Noord-brabant</option>
			<option value="11">Limburg</option>
		</select>
	</fieldset>
	
	<hr />
	
	<h2>20 Persoonlijke Vragen</h2>
	<p class="lead">
		Vul deze vragen zo nauwkeurig mogelijk in voor het meest accurate match resultaat. Bij "<em>Mijn antwoord...</em>" geeft u aan welk antwoord op u van toepassing is daarnaast geeft u bij "<em>Het antwoord wat ik verwacht...</em>" aan welk antwoord uw verwacht van een eventuele match-partner. U geeft daarna aan hoe belangrijk u deze vraag vindt, naar mate u de vraag belangrijker vindt weegt deze vraag zwaarder mee in het resultaat.
	</p>
	
	<?php
		$importance = array(
		    0 => 0,     /*Irrelevant*/
		    1 => 1,     /*Een beetje belangrijk*/
		    2 => 10,    /*Enigszins belangrijk*/
		    3 => 50,    /*Heel belangrijk*/
		    4 => 250    /*Bindend/Verplicht*/
		);
		for($i = 1; $i <= 20; $i++){
			$sql = "SELECT questions.question, quest_ans.answer
					FROM questions
					INNER JOIN quest_ans 
					ON questions.id = quest_ans.quest_id
					WHERE questions.id = {$i}
			";
			if(!$result = $mysqli->query($sql)) trigger_error('Fout in query: '.$mysqli->error);
			else {
				$quest_arr = array();
				$quest = "";
				while($r = $result->fetch_array(MYSQLI_ASSOC)){
					$quest_arr[] = $r['answer'];
					$quest = $r['question'];
				}?>
						<?php echo "<h3 id='question".$i."'>".$quest; ?></h3>
						<section class="columns question" role="structure">
							<fieldset class="radio structure-list" role="section">
								<label for="notifications" >Mijn antwoord...</label>
								<ul role="list">
									<?php 
										for ($j = 0; $j < count($quest_arr); $j++) {
											echo '<li><label><input type="radio" name="answer-'.$i.'" value='.$j.' /> '.$quest_arr[$j].'</label></li>';
										}
									 ?>
									<!--<li><label><input type="radio" name="" /> Heel belangrijk</label></li>-->
								</ul>
							</fieldset>
							
							
							<fieldset class="radio structure-list" role="section">
								<label for="notifications">Het antwoord wat ik verwacht...</label>
								<ul role="list">
									<?php 
										for ($j = 0; $j < count($quest_arr); $j++) {
											echo '<li><label><input type="checkbox" name="desired-answer-'.$i.'[]" value='.$j.' /> '.$quest_arr[$j].'</label></li>';
										}
									 ?>
									<!--<li><label><input type="checkbox" name="" /> Heel belangrijk</label></li>-->
								</ul>
							</fieldset>
						</section>
					
						<fieldset class="radio">
							<?php echo '<label for="importance-'.$i.'">Deze vraag is voor mij</label>
							<select name="importance-'.$i.'" id="importance-'.$i.'">'; ?>
							  <option value="0">Irrelevant</option>
							  <option value="1">Een beetje belangrijk</option>
							  <option value="2" selected>Enigszins belangrijk</option>
							  <option value="3">Heel belangrijk</option>
							  <option value="4">Bindend/Verplicht</option>
							</select>
						</fieldset>
						
						<hr />
					<?php } } ?>
	<fieldset class="form-actions">
		<input type="submit" id="submit" value="Profiel aanmaken/Bekijk uw matches" name="submit_questions" />
	</fieldset>
	<br />
	<p style="font-size: .8em;
	color: #999;">Door op "Profiel aanmaken/Bekijk uw matches" te klikken gaat u akkoord met de <a target="_blank" href="terms.php">algemene voorwaarden.</a></p>
</form>


<?php  
	require_once('../_footer.php') ?>

