<?php
	require_once('../_header.php');
	//if(!isset($_REQUEST['year']) || !isset($_REQUEST['year']) || !isset($_REQUEST['year'])) die("401 - Access denied");
?>

<style>
	fieldset.prev-next {
		margin: 0; padding: 0;
	}
	fieldset.prev-next ul {
		display: inline-block;
		list-style-type: none;
		margin: 0; padding: 0;
	}
	fieldset.prev-next ul li {
		display: inline-block;
	}
	fieldset.prev-next ul li a {
		display: inline-block;
		text-align: center;
		width: 65px;
	}
	fieldset.prev-next ul li .progress-bar__container {
		margin: 0 10px;
		width: 440px !important;
	}
	fieldset.prev-next ul li .progress-bar__container .progress {
	}
</style>
<script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/jquery.bxslider.js"> </script>
<script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/question.js"></script>

<form enctype="multipart/form-data" action="../request.php" method="POST" class="questions-form">
	<ul class="bxslider">
		<li>
		  	<h2>Persoonsgegevens</h2>	
		  	<fieldset>
		  		<input type="hidden" name="gender" value="<?= $_REQUEST['gender'] ?>">
		  		<input type="hidden" name="orientation" value="<?= $_REQUEST['orientation'] ?>">
		  		<input type="hidden" name="age" value="<?= floor(abs(strtotime(date('Y-m-d')) - strtotime($_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day'])) / (365*60*60*24)) ?>">
		  		<input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">
		  	</fieldset>			
			<fieldset>
				<label for="name">Voor- en Achternaam*</label>
				<input type="text" id="name" class="required" name="name" placeholder="Doutzen Kroes" />
				<span class="form-help hidden" id="empty-error">Veld niet ingevuld.</span>
			</fieldset>
			
			<fieldset id="username">
				<label for="username">Gebruikersnaam*</label>
				<input type="text" id="username" class="required" name="user" placeholder="doutzen"/>
				<span class="form-help hidden" id="empty-error">Veld niet ingevuld.</span>
				<span class="form-help hidden" id="user-error">Gebruikersnaam al in gebruik.</span>
			</fieldset>
			
			<fieldset>
				<label for="email">Email*</label>
				<input type="email" id="email" class="required" name="email" placeholder="hello@me.com" />
				<span class="form-help hidden" id="empty-error">Veld niet ingevuld.</span>
				<span class="form-help hidden" id="email-error">Geen geldig e-mailadres.</span>
			</fieldset>
			
			<fieldset>
				<label for="wachtwoord">Wachtwoord*</label>
				<input type="password" id="wachtwoord" class="required" name="wachtwoord" placeholder="Wachtwoord"/>
				<span class="form-help hidden" id="empty-error">Veld niet ingevuld.</span>
			</fieldset>
			
			<fieldset>
				<label for="hwachtwoord">Herhaal wachtwoord*</label>
				<input type="password" id="hwachtwoord" class="required" name="hwachtwoord" placeholder="Herhaal wachtwoord"/>
				<span class="form-help hidden" id="empty-error">Veld niet ingevuld.</span>
				<span class="form-help hidden" id="pass-error">Wachtwoorden komen niet overeen.</span>
			</fieldset>
			
			<fieldset>
				<label for="profielfoto">Profielfoto</label>
				<input type="file" id="profielfoto" name="profielfoto" />
			</fieldset>
			
			<fieldset>
				<label for="state">Provincie*</label>
				<select name="state" id="state" class="form-control">
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
	  	</li>
		<li>
			<h2>20 Persoonlijke Vragen</h2>
			<p class="lead">
			Vul deze vragen zo nauwkeurig mogelijk in voor het meest accurate match resultaat. Bij "<em>Mijn antwoord...</em>" geeft u aan welk antwoord op u van toepassing is daarnaast geeft u bij "<em>Het antwoord wat ik verwacht...</em>" aan welk antwoord uw verwacht van een eventuele match-partner. U geeft daarna aan hoe belangrijk u deze vraag vindt, naar mate u de vraag belangrijker vindt weegt deze vraag zwaarder mee in het resultaat. Het invullen van vragen is niet verplicht, alleen het wordt wel sterk aangeraden voor nauwekeurige keurigere berekening van jouw matches.
			</p>
		</li>
		<?php
		for($i = 1; $i <= 20; $i++){
			$sql = "SELECT questions.question, quest_ans.answer
						FROM questions INNER JOIN quest_ans 
							ON questions.id = quest_ans.quest_id
						WHERE questions.id = {$i}
			";
			
			$result = $mysqli->query($sql) or die($mysqli->error);
			$quest_arr = array(); $quest = "";
			while($r = $result->fetch_array(MYSQLI_ASSOC)){
				$quest_arr[] = $r['answer'];
				$quest = $r['question'];
			} ?>

			<?php if ($i % 2 != 0) echo "<li>"; ?> 
				<?php echo "<h3 id='question".$i."'>".$quest; ?></h3>
				<section class="columns question" role="structure">
					<fieldset class="radio structure-list" role="section">
						<label for="notifications" >Mijn antwoord...</label>
						<ul role="list">
							<?php 
								for ($j = 0; $j < count($quest_arr); $j++) {
									echo '<li><label><input type="radio" name="answer-'.$i.'" value='.($j+1).' /> '.$quest_arr[$j].'</label></li>';
								}
							?>
						</ul>
					</fieldset>
						
					<fieldset class="radio structure-list" role="section">
						<label for="notifications">Het antwoord wat ik verwacht...</label>
						<ul role="list">
							<?php 
								for ($j = 0; $j < count($quest_arr); $j++) {
									echo '<li><label><input type="checkbox" name="desired-answer-'.$i.'[]" value='.($j+1).' /> '.$quest_arr[$j].'</label></li>';
								}
							?>
						</ul>
					</fieldset>
				</section>
				
				<fieldset class="radio">
					<?php echo '<label for="importance-'.$i.'">Deze vraag is voor mij</label>
					<select name="importance-'.$i.'" id="importance-'.$i.'">'; ?>
						<option value="1">Irrelevant</option>
						<option value="2">Een beetje belangrijk</option>
						<option value="3" selected>Enigszins belangrijk</option>
						<option value="4">Heel belangrijk</option>
						<option value="5">Bindend/Verplicht</option>
					</select>
				</fieldset>
			<?php
			if ($i % 2 == 0) echo "</li>"; 
		} ?>
		<li>
			<h2> Gefeliciteerd!</h2>
			<p class="lead">Je bent nog &eacute;&eacute;n stap verwijderd van jouw droom man/vrouw. Klik op de knop "Profiel aanmaken/Bekijk uw matches" en u krijgt meteen een mooie lijst van matches. Schrik niet al het laden van de volgende pagina even duurt, dit komt doordat jouw matches meteen voor worden berekent. Dit doen we zodat je meteen van jou matches kan zien en jouw droom man/vrouw kan bewonderen.</p>
			<h3>Veel succes in de liefde!</h3>
			<p>Team Snelkoppeling.info</p>
			<fieldset class="form-actions">
				<input type="submit" id="submit" value="Profiel aanmaken/Bekijk uw matches" name="submit_questions" />
			</fieldset>
			<br />
			<p style="font-size: .8em; color: #999;">Door op "Profiel aanmaken/Bekijk uw matches" te klikken gaat u akkoord met de <a target="_blank" href="terms.php">algemene voorwaarden.</a></p>
		</li>
	</ul>
	<fieldset class="form-actions prev-next" style="margin-top: 20px;">
	<ul>
		<li class="prev">
		</li>
		<li style="margin: 0;"> 
			<div class="progress-bar__container">
				<span class="progress" style="width: 36.7px" data-width="36.7"></span>
			</div>
		</li>
		<li class="next">
		</li>
	</ul>
</fieldset>
</form>




<?php
	require_once('../_footer.php');
?>