<?php
require_once("../../../../functions.php");
//hier worden de gegevens die je in het login-form hebt ingevoerd omgezet naar een variabele
$user = $_REQUEST['user'];
$pass = sha1($_REQUEST['password']);

//hier wordt gecontroleerd dat de gebruiker wel via het login-form hier is gekomen.
//hij wordt terug gestuurd naar het login-form als dat niet zo is.
if (!isset($user) || !isset($pass)) {
	header( "Location: ../../../" );
} elseif (empty($user) || empty($pass)){
	die("hallo"); 
	header( "Location: ../../../" );
} else {
	include('../../../../config.php'); // het laden van de database
	$result = "SELECT * FROM gegevens WHERE username='".clean($user)."' AND password='".clean($pass)."' AND admin = 1";
	if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = mysqli_num_rows($result);
		if($count > 0) { 
			session_start();
			$_SESSION['username'] = $user;
			$_SESSION['sha1_password'] = $pass;
			
			header("Location: ../../../");
		} else {
			echo 'Incorrect login name or password. Please try again. <a href="../../../">Go back</a>';
		}
	}
} 
?>
