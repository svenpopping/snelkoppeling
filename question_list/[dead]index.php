<?php
	require_once('../_header.php');
	require_once('../functions.php');
?>
<script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/question.js"></script>
<form enctype="multipart/form-data" action="" method="POST" class="questions-form">

	<h2>Persoonsgegevens</h2>
						
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

	<hr />

	<h2>20 Persoonlijke Vragen</h2>
	<p class="lead">
		Vul deze vragen zo nauwkeurig mogelijk in voor het meest accurate match resultaat. Bij "<em>Mijn antwoord...</em>" geeft u aan welk antwoord op u van toepassing is daarnaast geeft u bij "<em>Het antwoord wat ik verwacht...</em>" aan welk antwoord uw verwacht van een eventuele match-partner. U geeft daarna aan hoe belangrijk u deze vraag vindt, naar mate u de vraag belangrijker vindt weegt deze vraag zwaarder mee in het resultaat.
	</p>

	<hr />
	
	<div class="questions"></div>
<?php
	require_once('../_footer.php');
?>