<?php
	/*
		Returns a query with a type of gender
		@param gender The gender which need to be returned (0 for only men, 1 for only women and % for both )
	*/
	function generate_query($gender) {
		global $person_array_data;
		return  "SELECT *
						FROM gegevens 
    						INNER JOIN get_answers ON gegevens.id = get_answers.person_id
    						INNER JOIN get_importance ON gegevens.id = get_importance.person_id
    						INNER JOIN get_desired ON gegevens.id = get_desired.person_id
					WHERE age >= ({$person_array_data['age']} / 2 + 6) 
						AND age <= ({$person_array_data['age']} * 2 - 12) AND id <> {$person_array_data['id']} 
						AND name <> '' AND gender = {$gender}
					GROUP BY gegevens.id";
	}

	/*
		Returns a array with potential matches for a person
		@param person_id The ID of the person
	*/
	function get_potential_matches($person_id) {
		global $person_id, $mysqli, $person_array_data, $states;

		// Get personal data
		$get_person_data = "SELECT * FROM gegevens WHERE id=".$person_id;
		$person_array_data = $mysqli->query($get_person_data)->fetch_array(MYSQLI_ASSOC);

		// As double check drop the created views
		$mysqli->query("DROP VIEW `get_answers`, `get_desired`, `get_importance`, `order_questions`;");

		// Create some views
		$mysqli->query("CREATE VIEW get_answers AS SELECT answers.person_id, GROUP_CONCAT(answers.ans) AS answers FROM answers GROUP BY answers.person_id") or die($mysqli->error);
		$mysqli->query("CREATE VIEW get_importance AS SELECT importance.person_id, GROUP_CONCAT(importance.imp) AS importance FROM importance GROUP BY importance.person_id") or die($mysqli->error);
		$mysqli->query("CREATE VIEW order_questions AS SELECT desired.person_id, GROUP_CONCAT(desired.ans ORDER BY desired.ans SEPARATOR '-') AS des FROM desired GROUP BY desired.person_id, desired.quest") or die($mysqli->error);
		$mysqli->query("CREATE VIEW get_desired AS SELECT person_id, GROUP_CONCAT(order_questions.des) AS desired FROM order_questions GROUP BY order_questions.person_id") or die($mysqli->error);

		//Get the query for the potential matches and execute query
		$get_potential_matches_query = ($person_array_data['sexse'] == 0) ? generate_query(($person_array_data['gender'] == 0) ? 1 : 0) : (($person_array_data['sexse'] == 1) ? generate_query(($person_array_data['gender'] == 0) ? 0 : 1) : generate_query("%"));
		$get_potential_matches_execute = $mysqli->query($get_potential_matches_query) or die($mysqli->error);
		
		//Make an array with all the potential matches
		$get_potential_matches_array = array();
		while($get_potential_matches_row = $get_potential_matches_execute->fetch_array(MYSQLI_ASSOC) ) {

			if(in_array($person_array_data['state'], ($states[$get_potential_matches_row['state']]))) {
				$get_potential_matches_array[] = $get_potential_matches_row;
			}
		}

		// Drop the created views
		$mysqli->query("DROP VIEW `get_answers`, `get_desired`, `get_importance`, `order_questions`;");

		//Return array
		return $get_potential_matches_array;
	}
?>