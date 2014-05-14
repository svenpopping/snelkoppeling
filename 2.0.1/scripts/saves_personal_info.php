<?php
require_once('../config.php');
require_once('../functions.php');


$requiredInput = array('age', 'state', 'orientation', 'gender', 'name', 'email', 'user', 'password', 'ip');
foreach ($requiredInput as $key => $value) {
	if(!isset($_POST[$value])) die($value);
}

$query = 'INSERT INTO  `snelkoppeling`.`gegevens` (
		`age` ,`state` ,`sexse` ,`gender` ,`name` ,`email` ,`username` ,`password` ,`ip` ,`admin`)
		VALUES (
			"'.clean($_POST['age']).'",  
			"'.clean($_POST['state']).'",  
			"'.clean($_POST['orientation']).'",  
			"'.clean($_POST['gender']).'",  
			"'.clean($_POST['name']).'",  
			"'.clean($_POST['email']).'",  
			"'.clean($_POST['user']).'",  
			"'.clean(password_hash($_POST['password'], PASSWORD_DEFAULT)).'",
			"'.clean($_POST['ip']).'",  
			0
		)';

$mysqli->query($query) or die($mysqli->error);
printf($mysqli->insert_id);
?>