<?php
session_start();
date_default_timezone_set("Australia/Sydney");
require("server/apikey.php");
require("server/openid.php");
require("server/stuff.php");
require("extra.php");

if (isset($_SESSION['player'])){
	echo "<a href='?page=logout'>LOGOUT</a><br>";
	echo $_SESSION['player']['name'] . "<br>" . $_SESSION['player']['steamid'] . "<br><br>";
 
	$roll = array();
	array_push($roll, "Mk200",  "Rook", "Rook", "Rook", "katiba", "MX", "MXM", "Rahim", "Mk-18", "Mk20", "SDAR", "TRG-20", "PDW2000", "PDW2000", "PDW2000", "Sting");

	echo count($roll), '<br><br>';
	$select = array_rand($roll, 1);

	shuffle($roll);
	print '
	<div id="scroller" style="width: 1280px; height: 720px; margin: 0 auto;">
		<div class="innerScrollArea">
			<ul>';	
	foreach ( $roll as $rol ) { 
		echo '<li><img src="img/', $rol, '.jpg" width="1080" height="720" /></li>';
	};
	echo '<li id="winner"><img src="img/', $roll[$select], '.jpg" width="1080" height="720" /></li>';
	$tail = array_rand($roll, 5);
	foreach ( $tail as $rol1 ) {
		echo '<li><img src="img/', $roll[$rol1], '.jpg" width="1080" height="720" /></li>';
	};
	print '
				</ul>
		</div>
	</div>';
	echo "<b>", $roll[$select], "</b><br>";
	print_r ($tail);
} else {
	echo "<a href='?page=login'>LOGIN!</a>";
}

?>