<?php
	// het starten van de session
	session_start();
	include('../../../../config.php'); // het laden van de databse
	
	// het controleren van de gegevens of ze wel kloppen. dit is voor de veiligheid
	// voor uitleg gaan vaan de map klanten.
	$user = sha1((isset($_SESSION['username'])) ? $_SESSION['username']: "");
	$pass = sha1((isset($_SESSION['sha1_password'])) ? $_SESSION['sha1_password']: "");
	if (!isset($user) || !isset($pass)) {
		die(header( "Location: ../../../"));
	}
	elseif (empty($user) || empty($pass)) {
		die(header("Location: ../../../"));
	}
	else{
		$result = "SELECT * FROM gegevens WHERE name='{$user}' AND password='{$pass}'";
		// Hier wordt gekeken of de gegevens kloppen
		if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
		else {
			$count = mysqli_num_rows($result);
			// Als de gegevens bestaan word je doorverwezen naar de pagina van de bestellingen
			//if($count <= 0) { die(header("Location: ../../../")); }
		}
	}
	
	session_unset(); // het deactiveren van de sessions 
	session_destroy(); // het verwijderen van de sessions
	
	header("Location: ../../../"); // en dan word je weer terug gestuurd naar de login-pagina
?>