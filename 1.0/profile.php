<?php
require_once('functions.php');
require_once('_header.php');

//Het defineren van $user en $pass
$user = (isset($_SESSION['username'])) ? $_SESSION['username']: "";
$pass = (isset($_SESSION['sha1_password'])) ? $_SESSION['sha1_password']: "";

//Een alert omdat mail verstuurd via snelkoppeling.info nog wel een in de spamfolder terechtkomen en dat in natuulijk zonde.


//Met deze if-statement wordt gekeken of men wel is ingelogd en op dit wel goed is gedaan (check met db)
if(!isset($user) || !isset($pass)) {
	die(header("Location: ./"));
}
elseif (empty($user) || empty($pass)) {
	die(header("Location: ./"));
} else {
	$result = "SELECT * FROM gegevens WHERE username='".clean($user)."' AND password='".clean($pass)."'";
	if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = mysqli_num_rows($result);
		if($count <= 0) die(header("Location: /"));
		
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$person_id = $r["id"];
	}
}

//Met deze if-statement wordt gekeken of er een admin ingelogd is. (Admin's kunnen alle profile zien)
if(($user == "bouke" || $user == "svenpopping" || $user == "doutzen") && isset($_GET['user'])){
	$username = (isset($_GET['user'])) ? $_GET['user'] : "";
	$sql = "SELECT * FROM gegevens WHERE username = '".clean($username)."'";
	
	if(!$result = $mysqli->query($sql)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$person_id = $r["id"];
	}
} else {
	$sql = "SELECT * FROM gegevens WHERE username = '".clean($user)."' AND password = '".clean($pass)."'";
}


if(!$result = $mysqli->query($sql)) {
    trigger_error('Fout in query: '.$mysqli->error);
}
else {
	$r = $result->fetch_array(MYSQLI_ASSOC);
	
	//Dit stuk zorgt ervoor dat de het bericht dat iemand wil verzenden ook daadwerkelijk verzonden wordt.
	if(isset($_POST['message'])) {
		$to_name = $_POST['to_name'];
		$to_email = $_POST['to_mail'];
		
		$to = "$to_name <$to_email>";
		$subject = "[Snelkoppeling] Bericht van een van jou matches";
		$message = str_replace("\n.", "\n..", $_POST['message']);
		
		
		$headers = "Reply-To: " . $r['name'] . " <" . $r['email'] . ">\r\n"; 
	    $headers .= "Return-Path: No Reply <bouke.regnerus@gmail.com>\r\n"; 
	    $headers .= "From: " . $r['name'] . " <" . $r['email'] . ">\r\n"; 
	    $headers .= "Organization: Snelkoppeling\r\n"; 
	    $headers .= "Content-Type: text/plain\r\n"; 
	    
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	    $headers .= "X-Priority: 3\r\n";
	    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
	    
		$headers .= "BCC: Bouke Regnerus <email.bouke@gmail.com>\r\n";
		
		//Hier wordt de mail daadwerkelijk verzonden
		mail($to,$subject,$message,$headers);
		echo '<div role="alert" class="info">
			<strong>Email Verstuurd</strong> <small>Het is nu aan uw match om deze te beantwoorden!</small> <a class="close" data-dismiss="alert">&#9747</a>
		</div><br />'; 
	}
	
	//Als men zijn/haar profile foto wil aanpassen zorgt dit stuk ervoor dat de oude verwijderd wordt en de nieuwe upgeload wordt en deze ook weer in de dn wordt opgeslagen.
	if(isset($_REQUEST['submit_profil_pic'])){
		$name = $r['picture'];
		$path = "server/_/original/";
		$types = array("image/bmp","image/gif","image/jpeg","image/png");	
		$target = "server/_/original/".basename($_FILES['profielfoto']['name']);
		
		if(move_uploaded_file($_FILES['profielfoto']['tmp_name'], $target)) {
			unlink('server/_/original/'.$r['picture']);
			$nname = random();
			$path_parts = pathinfo($target);
			rename($target, ("server/_/original/".$nname.".".$path_parts['extension']));
			
			$picture = $nname.".".$path_parts['extension'];
			$mysqli->query("UPDATE gegevens SET picture='".clean($picture)."' WHERE id='".clean($person_id)."'") or die($mysqli->error);
		}
		header("Location: http://snelkoppeling.info/user/");
	}
	echo '<div role="alert" class="info"><strong>Let op!</strong><small>E-mails verstuurd via snelkoppeling.info kunnen in uw spamfolder terechtkomen. Controleer deze, misschien heeft u wel een berichtje gekregen.</small></div><br />'; 
 ?>
 <h3>Gebruikersprofiel</h3>
 <section class="columns columns__profile" role="structure">
 	<div role="section">
 		<?php echo ($r['picture'] != "") ? '<img src="//snelkoppeling.info/server/_/large/'.$r['picture'].'" alt="'.$r['name'].'" class="profile-picture" />' : '<img src="//snelkoppeling.info/images/nopicture_large.jpg" alt="Onbekend" class="profile-picture" />'
 		 ?>
 		 <a href="#" id="change-profile-pic">Profielfoto bewerken</a>
 		 <form enctype="multipart/form-data" method="POST" action="" id="profile-pic-form" class="questions-form hidden">
	 		 <fieldset>
	 		 	<input type="file" id="profielfoto" name="profielfoto" />
	 		 </fieldset>
	 		 <fieldset>
	 		 	<input type="submit" id="submit" value="Bewerken" name="submit_profil_pic" />
	 		 </fieldset>
 		 </form>
 	</div>
 	<div role="section">	
 		<dl role="list">
 			<dt>Naam</dt>
 			<dd><?php 
 			echo ($r['username'] == "bouke" || $r['username'] == "svenpopping") ? '<img src="../images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "";
 			echo ($r['username'] == "Hiemstra" || $r['username'] == "sietse") ? '<img src="../images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : "";
 			echo ucwords($r['name']) ?></dd>
 			<dt>Geslacht</dt>
 			<dd><?php echo($r['gender'] == 0)? "Man" : (($r['gender'] == 1) ? "Vrouw" : "Onbekend") ?></dd>
 			<dt>Geaardheid</dt>
 			<dd><?php echo($r['sexse'] == 0)? "Heteroseksueel" : (($r['sexse'] == 1) ? "Homosexueel" : "Bisexueel") ?></dd>
 			<dt>Provincie</dt>
 			<dd>
 			<?php 
 			$states = array(
 				0 => "Friesland", 
 				1 => "Groningen", 
 				2 => "Drenthe",
 				3 => "Noord-Holland",
 				4 => "Flevoland",
  				5 => "Overijssel", 
 				6 => "Gelderland", 
 				7 => "Utrecht", 
 				8 => "Zuit-Holland",
 				9 => "Zeeland", 
 				10 => "Noord-Brabant",
 				11 => "Limburg"
 			);
 			echo $states[$r['state']];
 			 ?>
 			</dd>
 			<dt>Leeftijd</dt>
 			<dd><?php echo $r['age'] ?> jaar</dd>
 			<dt>Email</dt>
 			<dd><a href="mailto:<?php echo $r['email'] ?>"><?php echo $r['email'] ?></a></dd>
 		</dl>							
 	</div>
 </section>
 
 <hr />

<?php
}
require_once("saved_matches.php");
//require_once("match.php"); //Het laden van de matches
?>


<?php	
require_once("_footer.php");
?>