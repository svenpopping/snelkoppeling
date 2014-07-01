<?php
include('../../config.php');
	
	session_start();
	$user = $_SESSION['username'];
	$pass = $_SESSION['sha1_password'];
	if (!isset($user) || !isset($pass)) {
	die(header( "Location: ../"));
	}
	elseif (empty($user) || empty($pass)) {
	die(header("Location: ../"));
	}
	else{
		$result = mysql_query("SELECT * FROM admin WHERE user='{$user}' AND pass='{$pass}'") or die(mysql_error());

		$rowCheck = mysql_num_rows($result);
		if($rowCheck <= 0){
			die(header("Location: ../"));
		}
	}
?>