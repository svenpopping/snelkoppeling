<?php
require_once("../login/classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == false) {
	header("Location: //localhost/snelkoppeling/2.0.1/");
}

require_once('../_header.php');
require_once('../functions.php');

if($_SESSION['verified'] == 0) {
	echo '<div role="alert" class="info"><strong>Let op!</strong><small>U heeft uw e-mailadres nog niet bevestigd. Om gebruikt te kunen maken van de extra mogelijkheden, bevestig dan uw e-mailadres.</small></div><br />';
}

echo '<div role="alert" class="info"><strong>Let op!</strong><small>E-mails verstuurd via snelkoppeling.info kunnen in uw spamfolder terechtkomen. Controleer deze, misschien heeft u wel een berichtje gekregen.</small></div><br />'; 
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('a.back').hide();
		
		$("#columns__profile").load("http://localhost/snelkoppeling/2.0.1/user_profile/get_profile.php", function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});
		$("#columns__matches").load("http://localhost/snelkoppeling/2.0.1/user_profile/get_matches.php", function(response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				console.log(msg + xhr.status + " " + xhr.statusText);
			}
		});
	});
</script>
<div style="display: inline-block; margin-bottom: 20px;">
	<a class="back button" style="display: inline-block; width: 39px; margin-right: 10px">Terug</a>
	<h3 style="display: inline-block; padding-top: 3px;">Gebruikersprofiel</h3>
</div>
<section id="columns__profile" class="columns columns__profile" role="structure">
 	
</section>

<section id="columns__matches" role="structure"></section>


<?php	
require_once("../_footer.php");
?>