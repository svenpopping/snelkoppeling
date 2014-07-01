<?php 
	require_once("../config.php");
	$delete = (isset($_GET['id'])) ? $_GET['id'] : "";
	
	$mysqli->query("DELETE FROM gegevens WHERE id = {$delete}") or die($mysqli->error);
	$mysqli->query("DELETE FROM answers WHERE person_id = {$delete}") or die($mysqli->error);
	$mysqli->query("DELETE FROM importance WHERE person_id = {$delete}") or die($mysqli->error);
	$mysqli->query("DELETE FROM desired WHERE person_id = {$delete}") or die($mysqli->error);
	$mysqli->query("DELETE FROM matches WHERE A = {$delete} OR B = {$delete}") or die($mysqli->error);
	
	header("Location: http://snelkoppeling.info/admin/");
?>