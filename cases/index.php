<?php
session_start();
date_default_timezone_set("Australia/Sydney");
require("server/apikey.php");
require("server/openid.php");
require("server/stuff.php");
require("../../scripts/gamedb.php");

if (isset($_SESSION['player'])){
	echo "<a href='?page=logout'>LOGOUT</a><br>";
	echo $_SESSION['player']['name'] . "<br>" . $_SESSION['player']['steamid'] . "<br><br>";
	
	
	
	$roll = array();
	array_push($roll, "2k200", "mar-10",  "Rook", "Rook", "Rook", "katiba", "MX", "MXM", "Rahim", "Mk-18", "4-Five", "Zubr .45", "4-Five", "Mk20", "SDAR", "TRG-20", "PDW2000", "PDW2000", "PDW2000", "SMG_02_F", "Mk-14");

	echo count($roll), '<br><br>';
	$select = array_rand($roll, 1);

	shuffle($roll);

	foreach ( $roll as $rol ) { 
		echo "$rol<br>"; 
	} 

	echo "<b>", $roll[$select], "</b><br>";

	$tail = array_rand($roll, 6);

	foreach ( $tail as $rol ) {
		echo $roll[$rol] . '<br>';
	}
} else {
	echo "<a href='?page=login'>LOGIN!</a>";
}
?>
