<?php
	require_once("../../../config.php");
		
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	$question_id = (isset($_GET['question_id'])) ? $_GET['question_id'] : die("Geen geldige invoer");

	$query_get_question = "SELECT questions.question, GROUP_CONCAT(quest_ans.answer) AS answers 
								FROM `questions` INNER JOIN quest_ans ON questions.id = quest_ans.quest_id
								GROUP BY questions.id HAVING questions.id = {$question_id}";

	$array_get_question = $mysqli->query($query_get_question)->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);
	$array_explode_answers = explode(",", $array_get_question['answers']);


	echo '{"results": [ {
					"question": "'.$array_get_question['question'].'", 
					"answers" : [';
									
	for($i = 0; $i < count($array_explode_answers); $i++) {
		echo '"'.$array_explode_answers[$i].'"';
		if($i != count($array_explode_answers) - 1) echo ",";
	}			
	echo ']}]}';
?>