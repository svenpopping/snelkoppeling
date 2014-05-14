<?php
require_once("../login/classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == false) {
	header("Location: //localhost/snelkoppeling/2.0.1/");
}

require_once('../config.php');
if (isset($_SESSION['change_password']) AND $_SESSION['change_password'] == 1) {
	echo "Please change your password";
};

if( isset($_GET['user']) ) {
	if($_SESSION['verified'] == 1) {
		$check_if_match = $mysqli->query('SELECT * FROM matches WHERE (A = "'.$_SESSION['user_id'].'" AND B = (SELECT id FROM gegevens WHERE username="'.$_GET['user'].'")) OR (B = "'.$_SESSION['user_id'].'" AND A = (SELECT id FROM gegevens WHERE username="'.$_GET['user'].'"))')->num_rows or die($mysqli->error);
		if($check_if_match == 1) {
			$personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$_GET['user'].'"')->fetch_array(MYSQLI_ASSOC);
		} else {
			echo "error";
		}
	} else {
		$personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$_SESSION['user_name'].'" AND email = "'.$_SESSION['user_email'].'"')->fetch_array(MYSQLI_ASSOC);
	}
} else {
	$personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$_SESSION['user_name'].'" AND email = "'.$_SESSION['user_email'].'"')->fetch_array(MYSQLI_ASSOC);
}
?>
<div role="section">
 		<?= ($personal_info['picture'] != "") ? '<img src="http://snelkoppeling.info/server/_/large/'.$personal_info['picture'].'" alt="'.$personal_info['name'].'" class="profile-picture" />' : '<img src="//snelkoppeling.info/images/nopicture_large.jpg" alt="Onbekend" class="profile-picture" />' ?>
 		<?php if (!isset($_GET['user'])) { ?>
 		<a href="#" id="change-profile-pic">Profielfoto bewerken</a>
 		<form enctype="multipart/form-data" method="POST" action="" id="profile-pic-form" class="questions-form hidden">
	 		<fieldset>
	 			<input type="file" id="profielfoto" name="profielfoto" />
	 		</fieldset>
	 		<fieldset>
	 			<input type="submit" id="submit" value="Bewerken" name="submit_profil_pic" />
	 		</fieldset>
 		</form>
 		<?php } ?>
 	</div>
 	<div role="section">	
 		<dl role="list">
 			<dt>Naam</dt>
 				<dd>
 					<?php 
 						echo ($personal_info['name'] == "bouke" || $personal_info['name'] == "svenpopping") ? '<img src="../../images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "";
 						echo ($personal_info['name'] == "Hiemstra" || $personal_info['name'] == "sietse") ? '<img src="../../images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : "";
 						echo ucwords($personal_info['name']) 
 					?>
 				</dd>
 			<dt>Geslacht</dt>
 				<dd><?= ($personal_info['gender'] == 0)? "Man" : (($personal_info['gender'] == 1) ? "Vrouw" : "Onbekend") ?></dd>
 			<dt>Geaardheid</dt>
 				<dd><?= ($personal_info['sexse'] == 0)? "Heteroseksueel" : (($personal_info['sexse'] == 1) ? "Homosexueel" : "Bisexueel") ?></dd>
 			<dt>Provincie</dt>
 				<dd> <?= $states_names[$personal_info['state']]; ?> </dd>
 			<dt>Leeftijd</dt>
 				<dd><?=$personal_info['age'] ?> jaar</dd>
 			<dt>Email</dt>
 				<dd><a href="mailto:<?= $personal_info['email'] ?>"><?= $personal_info['email'] ?></a></dd>
 		</dl>							
 	</div>
 	<dl role="list" style="width: 100%">
 		<dt>Over jezelf</dt>
 			<dd><?=$personal_info['about_me'] ?></dd>
 		</dl>