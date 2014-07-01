<?php
function get_points($desired_answers_array, $given_answers, $importance_item) {
	global $importance;
	if(is_array($desired_answers_array)) {
		return (in_array($given_answers, $desired_answers_array)) ? ($importance[$importance_item]) : 0;
	}
	else return ($desired_answers_array == $given_answers) ? $importance[$importance_item] : 0;
}

function calculate_points($all_desired_list, $all_answers_list, $all_importance_list) {
	global $importance;
	$all_answers_array = explode(",", $all_answers_list);
	$all_importance_array = explode(",", $all_importance_list);
	$all_desired_array = explode(",", $all_desired_list);

	$total_questions = min(count($all_answers_array), count($all_importance_array), count($all_desired_array));

	$earned_points = 0;
	$max_points = 0;

	for($i = 0; $i < $total_questions; $i++) {
		if (strpos($all_desired_array[$i] , '-') !== false) {
   			$all_desired_array_explode = explode("-", $all_desired_array[$i]);
   			$earned_points += get_points($all_desired_array_explode, $all_answers_array[$i], $all_importance_array[$i])."<br />";
		} else {
			$earned_points += get_points($all_desired_array[$i], $all_answers_array[$i], $all_importance_array[$i])."<br />";
		}
		$max_points += $importance[$all_importance_array[$i]];
	} 

	try {
		return floor(($earned_points / $max_points) * 100 - (100 * (1 / $total_questions)));
	} catch (Exception $e) {
		return 1;
	}
}
?>