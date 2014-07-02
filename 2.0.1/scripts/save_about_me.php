<?php
require_once('../config.php');
require_once("../login/classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == false) {
  header("Location: //localhost/snelkoppeling/2.0.1/");
}

if(isset($_REQUEST['about_me'])) {
	$sql = "UPDATE gegevens SET about_me='".$_REQUEST['about_me']."' WHERE id='".$_SESSION['user_id']."'";
	$mysqli->query($sql);
}
?>