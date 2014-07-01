<?php
	/*Dit script zorgt er voor dat de achtergrond op de paginas bij elke bezoeker veranderd.*/
	
	header('Content-type: image/jpg'); /*Content type wordt op jpg gezet zodat PHP een afbeelding terug geeft.*/
	
	require_once('config.php');
	
	$arr = array();
	global $states, $mysqli;
	
	/*Alle afbeeldingen worden uit de database geladen.*/
	$sql_person = "SELECT DISTINCT
						picture
					FROM gegevens
					WHERE picture <> ''";
	if(!$result = $mysqli->query($sql_person)) {
		trigger_error('Fout in query: '.$mysqli->error);
	} else {
		
		while($row = $result->fetch_row()) {
		  $pictures[]=$row[0];
		}
		
		shuffle($pictures); //Afbeeldingen worden geshuffled.
		
		$pictures = array_slice($pictures, 0, 35); //De array met afbeeldingen wordt afgekapt bij 35.
		
		$grid = imagecreatefromjpeg('http://snelkoppeling.info/images/avatar-background.jpg');
		
		$x = 0;
		$y = 0;
		foreach($pictures as $picture) {
			$extension = strtolower(substr(strrchr($picture,'.'),1)); //Er wordt gekeken welke extensie een afbeelding heeft.
			
			/*Het werkelijke afbeelding bestand wordt geladen van de server.*/
			$ch = curl_init();
			$options =  array(
			
			        CURLOPT_URL => 'http://snelkoppeling.info/server/_/medium/' . $picture,
			        CURLOPT_HTTPHEADER => array('Content-type: image/'.$extension),
			        CURLOPT_ENCODING => "",
			        CURLOPT_RETURNTRANSFER => true,
			        CURLOPT_HTTPGET => true,
			        CURLOPT_CONNECTTIMEOUT => 60,
			        CURLOPT_TIMEOUT => 60
			
			    );
			curl_setopt_array($ch, $options);
			$response = curl_exec($ch);
			
			if(!curl_errno($ch)){
			    curl_close($ch);
			    $img = imagecreatefromstring($response); //De afbeelding wordt in het PHP geheugen geladen.
			}
			else{
			    curl_close($ch);
			    die(curl_error($ch));
			}
			
			
			imagefilter($img, IMG_FILTER_CONTRAST, 20);
			imagefilter($img, IMG_FILTER_BRIGHTNESS, -60);
			
			imagecopymerge($grid, $img, $x, $y, 0, 0, 170, 170, 100); //De afbeelding wordt toegevoegd aan de achtergrond.
			imagedestroy($img); //Geheugen wordt geleegd
			
			/*Bij elke loop wordt de plaats van een afbeeling opgeschoven.*/
			$x = $x + 170;
			if($x >= 850) {
				$x = 0;
				$y = $y + 170;
			}
		}
		imagejpeg($grid, NULL, 80);
		imagedestroy($grid); //Geheugen wordt geleegd
	}