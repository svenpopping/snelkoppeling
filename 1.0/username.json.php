<?php
	include ('config.php');
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	$sql = "SELECT username FROM gegevens WHERE username <> ''";
	
	echo '{"results": [';
	$i = 0;
	if(!$result = $mysqli->query($sql)) trigger_error('Fout in query: '.$mysqli->error);
	else {
		$count = $result->num_rows;
		while($r = $result->fetch_array(MYSQLI_ASSOC)){
			echo '{"id": "'.strtolower($r['username']).'"}';
			
			echo ($i < $count-1) ? ',' : '';
			$i++;
		}
	}
	echo ']}';
	
	?>