<?php 
require_once('_header.php'); //Header wordt toegevoegd aan het document

/*If loop kijkt of er een sessie bestaat en of een gebruiker dus is ingelogd, wanneer dit het geval is wordt deze gebruiker door gestuurd naar de gebruikerspagina*/
if(isset($_SESSION['username']) && isset($_SESSION['sha1_password'])) {
	$user = (isset($_SESSION['username'])) ? $_SESSION['username']: "";
	$pass = (isset($_SESSION['sha1_password'])) ? $_SESSION['sha1_password']: "";
	
	$result = "SELECT * FROM gegevens WHERE username='{$user}' AND password='{$pass}'";
	if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = mysqli_num_rows($result);
		if($count > 0) { die(header("Location: /user/")); }
	}
} 

?>
<script type="text/javascript">
$(document).ready(function() {
	
	/*Javascript code die een error aangeeft wanneer een gebruiker geen informatie heeft ingevuld in het geboortedatum veld.*/
	$('#aanmelden').click(function() {
		if($("#day").val() == document.getElementById("day").defaultValue){
			$('#error-day').removeClass('hidden');
			return false;
		}
		if($('#month').val() == 0){
			$('#error-month').removeClass('hidden');
			return false;
		}
		if($('#year').val() == ''){
			$('#error-year').removeClass('hidden');
			return false;
		}
	});
});
</script>
<nav id="navigation" role="navigation sitemap g two-thirds">
	<!-- Inlog formulier voor bestaande gebruikers -->
	<form action="login/sessions/create/">
    	<ul class="form-fields multi-list  three-cols">
    		<li class="float-left">
    		    <input type="text" class="text-input" id="name" name="username" placeholder="Gebruikersnaam">
    		</li>
    	    <li class="float-left">
    	        <input type="password" class="text-input" id="pass" name="pass" placeholder="Wachtwoord">
    	    </li>
    	    <li><input type="submit" class="btn btn--longer btn--login" value="Inloggen" /></li>
    	</ul>  
	</form>				
</nav>	

<section class="landing__background">
	<!-- Aanmeld formulier voor nieuwe klanten -->
	<form action="questions_list.php" class="landing__box" method="post">
		<h2><img src="//snelkoppeling.info/images/snelkoppeling-64.png" alt="Snelkoppeling" /> De beste gratis matches uit jouw omgeving!</h2>
		
		<!-- Geslacht -->
		<fieldset>
			<label for="gender">Ik ben een</label>
			<select name="gender" id="gender">
			  <option value="0" selected>Man</option>
			  <option value="1">Vrouw</option>
			</select>
		</fieldset>
		
		<!-- Geaardheid -->
		<fieldset>
			<label for="orientation">Mijn geaardheid is</label>
			<select name="orientation" id="orientation">
			  <option value="0" selected>Heteroseksueel</option>
			  <option value="1">Homosexueel</option>
			  <option value="2">Biseksueel</option>
			</select>
		</fieldset>
		
		<!-- Geboortedatum -->
		<fieldset>
			<label for="birth">Mijn geboorte datum is</label>
			
			<ul class="multi-list  three-cols">
				<li class="float-left">
				    <input type="number" class="text-input" id="day" placeholder="Dag" maxlength="2" name="day">
				    <p class="form-help hidden" id="error-day">Vul de dag in.</p>
				</li>
			    <li class="float-left">
			    	<select name="month" id="month">
			    	  <option value="0" disabled selected>Maand</option>
			    	  <option value="01">Januari</option>
			    	  <option value="02">Februari</option>
			    	  <option value="03">Maart</option>
			    	  <option value="04">April</option>
			    	  <option value="05">Mei</option>
			    	  <option value="06">Juni</option>
			    	  <option value="07">Juli</option>
			    	  <option value="08">Augustus</option>
			    	  <option value="09">September</option>
			    	  <option value="10">Oktober</option>
			    	  <option value="11">November</option>
			    	  <option value="12">December</option>
			    	</select>
			    	<p class="form-help hidden" id="error-month">Selecteer een maad.</p>
			    </li>
			    <li>
			        <input type="number" class="text-input" id="year" placeholder="Jaar" maxlength="4" name="year">
			        <p class="form-help hidden" id="error-year">Vul het jaar in.</p>
			    </li>
			</ul> 
		</fieldset>
	
		<!-- Verstuur knop -->
		<fieldset class="form-actions">
			<input type="submit" id="aanmelden" name="signup" value="Aanmelden" />
		</fieldset>
	</form>
</section>

</section>
	

<?php  
	require_once('_footer.php') //Footer wordt toegevoegd aan het document ?>
