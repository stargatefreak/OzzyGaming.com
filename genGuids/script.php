<?php
	SESSION_START();
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	if (!isset($_SESSION['sec']) || $_SESSION['sec'] !== "ks92"){
		die("Unauthorised Access");
	}
	
	require_once("../../scripts/gamedb.php");
	
	$player = isset($_POST['p']) ? $_POST['p'] : null;
	$guid = isset($_POST['g']) ? $_POST['g'] : null;
	
	if ($player === null || $guid === null) {
		die("Values not passed");
	}
	
	$query = $gdb->prepare("UPDATE players SET guid = :guid WHERE playerid = :playerid AND uid = :uid");
	$query->bindValue(":guid",$guid);
	$query->bindValue(":playerid",$player['playerid']);
	$query->bindValue(":uid",$player['uid']);
	$query->execute();
	
	echo $player['name'] . " added with GUID of " . $guid;
?>