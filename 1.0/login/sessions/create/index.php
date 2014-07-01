<?php
require_once('../../../functions.php');

$user = $_REQUEST['username'];
$pass = sha1($_REQUEST['pass']);

if ($_SERVER['HTTP_REFERER'] == "http://snelkoppeling.info/questions_list.php"){
	$user = $_GET['username'];
	$pass = $_GET['pass'];
}

if (!isset($user) || !isset($pass)) {
	//header( "Location: ../../../" );
}
elseif (empty($user) || empty($pass)) {
	//header( "Location: ../../../" );
} else{
	include('../../../config.php'); // het laden van de database
	$result = "SELECT * FROM gegevens WHERE username='".clean($user)."' AND password='".clean($pass)."'";
	if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = mysqli_num_rows($result);
		if($count > 0) { 
			session_start();
			$_SESSION['username'] = $user;
			$_SESSION['sha1_password'] = $pass;
			
			$mysqli->query("UPDATE gegevens SET last_login = now() WHERE username='".clean($user)."' AND password='".clean($pass)."'");
			
			header("Location: ../../../user/");
		} else {
			echo 'Incorrect login name or password. Please try again. <a href="../../../">Go back</a>';
		}
	}
} 
?>
