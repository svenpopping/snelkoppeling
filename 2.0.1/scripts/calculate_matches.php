<?php
  /*
    Algorithme Datingsite Snelkoppeling.info v2.1.3

    Version: 3.1.3
    Updated: May 9th, 2014

    Copyright © Sietse de Boer, Rene Hiemstra, Sven Popping, Bouke Regnerus.

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0
  */    

  require_once('../config.php');
  require_once('../functions.php');
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

  /*
    Returns the amount of points that a person gets for one of the questions
  */
  function get_points($desired_answers_array, $given_answers, $importance_item) {
    global $importance;
    if(is_array($desired_answers_array)) {
      return (in_array($given_answers, $desired_answers_array)) ? ($importance[$importance_item]) : 0;
    }
    else return ($desired_answers_array == $given_answers) ? $importance[$importance_item] : 0;
  }

  /*
    Calculate the points a potential match and the person and vice versa for each question. At the end it will return 
    a percentage of the earned points and the max total points
  */
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

    if($earned_points != 0 || $max_points != 0) {
      return floor(($earned_points / $max_points) * 100);
    } else {
      return "0";
    }
  }

  /*
    Generates the insert query, to insert all the matches in one query
  */
  function generate_insert_query($matches_array) {
    global $person_id;
    $query = "INSERT INTO  `snelkoppeling`.`matches` (`id` ,`A` ,`B` ,`match`) VALUES";

    for($i = 0; $i < count($matches_array); $i++) {
      $query .= "(NULL, '{$person_id}', '{$matches_array[$i][0]}', '{$matches_array[$i][1]}'),";
    }
    return mb_substr($query, 0, -1);
  }
  
  /*
    Main methode
  */

  $person_id = (isset($_GET['person_id'])) ? $_GET['person_id'] : die("Geen toegang");

  // Create and drop view
  $mysqli->query("DROP VIEW `person_order_questions`;");
  $mysqli->query("CREATE VIEW person_order_questions AS SELECT desired.person_id, GROUP_CONCAT(desired.ans ORDER BY desired.ans SEPARATOR '-') AS des FROM desired GROUP BY desired.person_id, desired.quest HAVING desired.person_id = {$person_id}") or die($mysqli->error);

  // Get personal data - answers, desired_answers and importance;
  $person_answers_list = $mysqli->query("SELECT answers.person_id, GROUP_CONCAT(answers.ans) AS answers FROM answers GROUP BY answers.person_id HAVING answers.person_id = {$person_id}")->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);
  $person_importance_list = $mysqli->query("SELECT importance.person_id, GROUP_CONCAT(importance.imp) AS importance FROM importance GROUP BY importance.person_id HAVING importance.person_id = {$person_id}")->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);
  $person_desired_list = $mysqli->query("SELECT person_order_questions.person_id, GROUP_CONCAT(person_order_questions.des) AS desired FROM person_order_questions GROUP BY person_order_questions.person_id")->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);

  // Double check drop view
  $mysqli->query("DROP VIEW `person_order_questions`;") or die($mysqli->error);

  // Get all te potential matches
  $get_potential_matches = get_potential_matches($person_id);

  // Calculate the number of questions fill in by the person
  $total_questions = min(count(explode(",", $person_desired_list['desired'])), count(explode(",", $person_importance_list['importance'])), count(explode(",", $person_answers_list['answers'])));

  // Calculate the percentage of the match
  foreach ($get_potential_matches as $potential_match) {
    $person_a_person_b = calculate_points($person_desired_list['desired'], $potential_match['answers'] ,$person_importance_list['importance']);
    $person_b_person_a = calculate_points($potential_match['desired'], $person_answers_list['answers'] ,$potential_match['importance']);
    
    if($person_a_person_b > 0 && $person_b_person_a > 0 && $total_questions != 0) {
      $percent = floor(sqrt($person_a_person_b * $person_b_person_a) - (100 * (1 / $total_questions)));
      if($percent > 1) {
        $matches_array[] = array($potential_match['id'], $percent);
      }
    }
  }

  // Add the percentage to the database
  $insert_query = generate_insert_query($matches_array);
  $mysqli->query("DELETE FROM matches WHERE A = {$person_id} OR B = {$person_id}") or die($mysqli->error);
  $mysqli->query($insert_query) or die($mysqli->error);
?>




