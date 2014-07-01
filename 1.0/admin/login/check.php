<?php
$user = (isset($_SESSION['username'])) ? $_SESSION['username']: "";
$pass = (isset($_SESSION['sha1_password'])) ? $_SESSION['sha1_password']: "";

//$code = (isset($_GET['code'])) ? $_GET['code'] : "";


if (!isset($user) || !isset($pass)) {
	die(header( "Location: /"));
}
elseif (empty($user) || empty($pass)) {
	die(header("Location: /"));
} else {
	// Deze querie is er om te kijken of de gevenens in de database voor komen
	$result = "SELECT * FROM gegevens WHERE username='{$user}' AND password='{$pass}'";
	// Hier wordt gekeken of de gegevens kloppen
	if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = mysqli_num_rows($result);
		// Als de gegevens bestaan word je doorverwezen naar de pagina van de bestellingen
		if($count <= 0) die(header("Location: /"));
		
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$person_id = $r["id"];
	}
}
?>