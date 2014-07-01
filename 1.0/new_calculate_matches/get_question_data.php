<?php
function get_question_data($person_id) {
	global $mysqli;

	// (Re)difin
	$get_question_data_answers_explode = array();
	$get_question_data_desired_explode = array();
	$get_question_data_importance_explode = array();

	//Fetch desired answers from the database
	$get_question_data_desired_query = "SELECT person_id, GROUP_CONCAT(ans) FROM desired GROUP BY person_id, quest HAVING person_id = {$person_id}";
	$get_question_data_desired_execute = $mysqli->query($get_question_data_desired_query) or die ($mysqli->error());

	while($get_question_data_desired_fetch = $get_question_data_desired_execute->fetch_array(MYSQLI_NUM)) {
		if(strpos($get_question_data_desired_fetch[1], ",") !== false) {
			$temp_explode_arr = explode(",", $get_question_data_desired_fetch[1]);
			$get_question_data_desired_explode[] = $temp_explode_arr;
			$temp_explode_arr = array();
		} else {
			$get_question_data_desired_explode[] = $get_question_data_desired_fetch[1];
		}
	}

	return array($get_question_data_answers_explode, $get_question_data_desired_explode, $get_question_data_importance_explode);
}
?>