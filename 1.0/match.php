<?php 
 /*
   Algorithme Datingsite Snelkoppeling.info v2.1.3
 
   Version: 2.1.3
	Updated: April 7th, 2013

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

   Copyright © Sietse de Boer, Rene Hiemstra, Sven Popping, Bouke Regnerus All rights reserved.
 */		
 	$person_id = (isset($_GET['id'])) ? $_GET['id'] : die("Niet toegangelijk");
	require_once('config.php');
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
	
	function points($des_arr, $ans, $imp) {
		global $importance; $i = 0;
		if(is_array($des_arr)) {
			foreach($des_arr as $des) 
				if($des == $ans) : $i = $importance[$imp]; break; endif;
			return $i;
		} 
		else return ($des_arr == $ans) ? ($importance[$imp]) : 0;
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
				$i = 0; $j = 0;
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
					if(!in_array(($person["state"]), ($states[$j]))) unset($arr[$i]);	
				}
			}
			return $arr;
		}
	}
	
	function calculate($id, $person_id) {
		global $mysqli, $importance;
		$points = 0; $tot_points = 0;		
		for($i = 1; $i <= 20; $i++){
			$q = "	SELECT 
						ans
					FROM answers
					WHERE person_id = {$person_id}
					AND quest = {$i}
			";
			$s = "	SELECT 
						importance.imp, 
						desired.ans AS des_ans
					FROM desired
					INNER JOIN importance
					ON (desired.quest = importance.quest)
					WHERE desired.person_id = {$id}
					AND importance.person_id = {$id}
					AND desired.quest = {$i}
			";
			if(!$result = $mysqli->query($q)) trigger_error('Fout in query: '.$mysqli->error);
			else {
				while($r = $result->fetch_array(MYSQLI_ASSOC)){
					if(!$result = $mysqli->query($s)) trigger_error('Fout in query: '.$mysqli->error);
					else {
						while($w = $result->fetch_array(MYSQLI_ASSOC)){
							$des_arr[] = $w['des_ans'];
							$imp = $w['imp'];
						}
						if($r['ans'] != 0 && !empty($des_arr)){
							$points += points($des_arr, $r['ans'], $imp);
							$tot_points += $importance[$imp];
						}
					}
					$des_arr = array();
				}
			}
		}
		if($points != 0 && $tot_points != 0){
			$score = 0;
			$score = round((($points / $tot_points) * 100));
			return $score;
		} else {	
			return $score = 0;
		}
	}
	$sql = "SELECT state, name, age FROM gegevens WHERE id = '".$person_id."'";
	if(!$result = $mysqli->query($sql)) {
	    trigger_error('Fout in query: '.$mysqli->error);
	}
	else {
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$state = $r['state'];	
	}
	$select = array();
	$select = select($person_id);
	$score = array(); $f = 0; $list = array();
	foreach ($select as $key => $value) {
		$s1 = calculate($person_id, $value['id']);
		$s2 = calculate($value['id'], $person_id);
		$matches = "SELECT * 
					FROM  
						`matches` 
					WHERE 
						(a = '".$person_id."' AND b = '".$value['id']."')
					OR 
						(a = '".$value['id']."' AND b = '".$person_id."')
		";
		if(!$result = $mysqli->query($matches)) trigger_error('Fout in query: '.$mysqli->error);
		else {
			$count = mysqli_num_rows($result);
			if($count <= 0) {
				$mysqli->query("INSERT INTO  `snelkoppeling`.`matches` (
									`id` ,
									`A` ,
									`B` ,
									`match`
									)
									VALUES (
									NULL ,  '".$person_id."',  '".$value['id']."',  '".round(sqrt($s1 * $s2))."'
									);
							");
			}
		}
		$f++;
	}
	$login = "SELECT username, password FROM gegevens WHERE id = '".$person_id."'";
	if(!$result = $mysqli->query($login)) {
		trigger_error('Fout in query: '.$mysqli->error);
	} else {
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$redir = "?username=".urlencode($r['username'])."&pass=".urlencode($r['password']);
		die(header("Location: ../login/sessions/create/".$redir));
	}
?>	