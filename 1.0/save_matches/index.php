<?php 
 	echo "<pre>";
 	require_once('../config.php');
  	$persons = "SELECT id FROM gegevens";
 	if(!$result = $mysqli->query($persons)) {
 	    trigger_error('Fout in query: '.$mysqli->error);
 	} else {
 		while($j = $result->fetch_array(MYSQLI_ASSOC)){
 			$gegevens[] = $j['id'];
 		}
	}
	$states = array(
		0 => array(0, 1, 2, 3, 4), 			/* friesland */
		1 => array(1, 0, 2), 				/* groningen */
		2 => array(2, 0, 1, 5), 			/* drenthe */
		3 => array(3, 0, 4, 7, 8), 			/* noord-holland */
		4 => array(4, 0, 5, 6, 3, 7),	 	/* flevoland */
		5 => array(5, 6, 4, 2, 0), 			/* overijssel */
		6 => array(6, 5, 4, 7, 8, 10, 11), 	/* gelderland */
		7 => array(7, 3, 8, 5, 6), 			/* utrecht */
		8 => array(8, 9, 10, 6, 7, 3), 		/* zuid-holland */
		9 => array(9, 8, 10), 				/* zeeland */
		10 => array(10, 9, 8, 6, 11), 		/* noord-brabant */
		11 => array(11, 10, 6)				/* limburg */
	);
	
	
	
	$count = count($gegevens);
	for ($i = 0; $i < $count; $i++) {
		$person_id = $gegevens[$i];
		$select = select($person_id);
		echo "<table>";	
			$count = count($select);
			for ($j = 0; $j < $count; $j++) {
				echo "<tr>";
					echo "<td>".$person_id."</td><td>".$select[$j]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}
	
	
	
	
	function select($id) {
		$arr = array();
		global $states, $mysqli;
		$sql_person = "SELECT
							gender,
							sexse,
							state
						FROM gegevens
						WHERE ID = {$id}";
		if(!$result = $mysqli->query($sql_person)) {
			trigger_error('Fout in query: '.$mysqli->error);
		} else {
			$person = array();
			$person = $result->fetch_array(MYSQLI_ASSOC);
			$sql = "SELECT 
			            id, 
			            age,
			            state,
			            sexse,
			            gender
			        FROM gegevens 
			        WHERE AGE >= ((SELECT 
			                        age 
			                        FROM gegevens 
			                        WHERE id = {$id}) / 2 + 6)
			            AND AGE <= ((SELECT 
			                        age 
			                        FROM gegevens 
			                        WHERE id = {$id}) * 2 - 12)  
			            AND ID <> {$id}
			            AND name <> ''
			";
			if(!$result = $mysqli->query($sql)) {
			    trigger_error('Fout in query: '.$mysqli->error);
			}
			else {
				$i = 0; $j = 0;	$all = array();
				while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
					$arr[$i] = $r; $i++;
				}
				$count = count($arr);
				for ($i = 0; $i < $count; $i++) {
					$j = $arr[$i]["state"];
					if($person['sexse'] == 0){
						if($person['gender'] == 0){
							if (($arr[$i]['gender']) == 0) unset($arr[$i]);
						} elseif($person['gender'] == 1){
							if ($arr[$i]['gender'] == 1) unset($arr[$i]); 
						}
					} elseif($person['sexse'] == 1){
						if($person['gender'] == 0){
							if ($arr[$i]['gender'] == 1 || $arr[$i]['sexse'] == 0) unset($arr[$i]);
						} elseif($person['gender'] == 1){
							if ($arr[$i]['gender'] == 0 || $arr[$i]['sexse'] == 0) unset($arr[$i]);
						}	
					} elseif($person['sexse'] == 2){
						if($person['gender'] == 0){
							if (($arr[$i]['gender'] == 0 && $arr[$i]['sexse'] == 0) || ($arr[$i]['gender'] == 1 && $arr[$i]['sexse'] == 1)) unset($arr[$i]);
						} elseif($person['gender'] == 1){
							if (($arr[$i]['gender'] == 1 && $arr[$i]['sexse'] == 0) || ($arr[$i]['gender'] == 0 && $arr[$i]['sexse'] == 1)) unset($arr[$i]);
						}	
					}
					if (!empty($arr[$i]['id'])){
						$all[] = $arr[$i]['id'];
					}
				}
			}
			return $all;
		}
	}?>	