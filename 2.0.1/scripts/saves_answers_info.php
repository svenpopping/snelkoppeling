<?php
require_once('../config.php');
require_once('../functions.php');

if(!isset($_POST['result']) || !isset($_POST['id'])) die("500 - Bad Access");

$person_id = $_POST['id'];
$count = 1;
$all_info = json_decode($_POST['result'], true);

$query = "INSERT INTO  `snelkoppeling`.`matches` (`id` ,`A` ,`B` ,`match`) VALUES";

$query_answers = "INSERT INTO `snelkoppeling`.`answers` (`person_id`, `ans`, `quest`) VALUES";
$query_desired = "INSERT INTO `snelkoppeling`.`desired` (`person_id`, `ans`, `quest`) VALUES";
$query_importance = "INSERT INTO `snelkoppeling`.`importance` (`person_id`, `imp`, `quest`) VALUES";

foreach ($all_info['result'] as $key => $value) {
	//print_r($value['array']);
	$query_answers .= "({$person_id}, '".$value['answer']."', {$count}),";

	foreach ($value['array'] as $array => $item) {
		$query_desired .= "({$person_id}, '".$item."', {$count}),";
	}
	$query_importance .= "({$person_id}, '".$value['importance']."', {$count}),";

	$count++;
}

$mysqli->query(mb_substr($query_answers, 0, -1)) or die($mysqli->error);
$mysqli->query(mb_substr($query_desired, 0, -1)) or die($mysqli->error);
$mysqli->query(mb_substr($query_importance, 0, -1)) or die($mysqli->error);
?>