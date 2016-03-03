<?php
function getTimeAgo($inputString){
	$secs = (time() - strtotime($inputString));
	$mins = 0;
	$hrs = 0;
	$days = 0;
	
	if ($secs > 120){
		$mins = floor($secs / 60);
		$secs = $secs % 60;
	}
	
	if ($mins > 60) {
		$hrs = floor($mins / 60);
		$mins = $mins % 60;
	}
	
	if ($hrs > 24) {
		$days = floor($hrs / 24);
		$hrs = $hrs % 24;
	}
	
	$timeOutput = "";
	if ($days == 0){
		if ($hrs == 0) {
			if ($mins == 0){
				$timeOutput = $secs . "s";
			} else {
				$timeOutput = $mins . "m, " . $secs . "s";
			}
		} else {
			$timeOutput = $hrs . "h, " . $mins . "m";
		}
	} else {
		$timeOutput = $days . "day, " . $hrs . "hr";
	}
	
	return $timeOutput;
}



function playtimeToRealtime($timeInput){
	$timeArray = explode(".",$timeInput);
	
	$hours = $timeArray[0];
	$mins = 0;
	
	if (count($timeArray) > 1){
		$mins = $timeArray[1];
		
		if ($mins == "25"){
			$mins = "15";
		} elseif ($mins == "5"){
			$mins = "30";
		} elseif ($mins == "75"){
			$mins = "45";
		}
	}
	
	return $hours . " hours, " . $mins . " minutes";
}


function formatCash($cash){
	$input = (String)$cash;
	// Number of digits - 1 / 3 = number of commas
	$numCommas = floor((strlen($input)-1)/3);
	if ($numCommas == 0){
		$formattedCash = "$" . $input;
		return $formattedCash;
		die();
	} else {
		$formattedCash = $input;
		for ($i=1;$i<=$numCommas; $i++){
			$pos = 3 * $i + ($i - 1);
			$front = substr($formattedCash,0,(strlen($formattedCash)-$pos));
			$back = substr($formattedCash,(strlen($formattedCash)-$pos));
			$new = $front . "," . $back;
			$formattedCash = $new;
		}
		$formattedCash = "$" . $formattedCash;
		return $formattedCash;
	}
}



// TEMPORARY :)
function genStats($type,$gdb){
	if ($type == "general"){
		// Number of players
		$query = $gdb->prepare("SELECT count(*) AS numplayers FROM players");
		$query->execute();
		$numplayers = $query->fetch(PDO::FETCH_ASSOC);
		
		// Total Funds
		$query = $gdb->prepare("SELECT (sum(cash)+sum(bankacc)) AS totalcash FROM players");
		$query->execute();
		$totalcash = $query->fetch(PDO::FETCH_ASSOC);
		
		// Number of vehicles
		$query = $gdb->prepare("SELECT count(*) AS numvehicles FROM vehicles WHERE alive = '1'");
		$query->execute();
		$numvehicles = $query->fetch(PDO::FETCH_ASSOC);
		
		// Number of houses
		$query = $gdb->prepare("SELECT count(*) AS numhouses FROM houses");
		$query->execute();
		$numhouses = $query->fetch(PDO::FETCH_ASSOC);
		
		// Number of Gangs
		$query = $gdb->prepare("SELECT count(*) AS numgangs FROM gangs");
		$query->execute();
		$numgangs = $query->fetch(PDO::FETCH_ASSOC);
	?>
		<p>General Server Statistics</p>
		<table class="table table-striped">
			<tbody>
				<tr> <td>Number of Players</td> <td><?php echo $numplayers['numplayers']; ?></td> </tr>
				<tr> <td>Total Cash</td> <td><?php echo formatCash($totalcash['totalcash']); ?></td> </tr>
				<tr> <td>Number of Alive Vehicles</td> <td><?php echo $numvehicles['numvehicles']; ?></td> </tr>
				<tr> <td>Number of Owned Houses</td> <td><?php echo $numhouses['numhouses']; ?></td> </tr>
				<tr> <td>Number of Gangs</td> <td><?php echo $numgangs['numgangs']; ?></td> </tr>
			</tbody>
		</table>
	<?php
	} else {
		if ($type == "cop"){
			$query = $gdb->prepare("SELECT name, copCounter AS counter FROM players ORDER BY copCounter DESC LIMIT 15");
		} elseif ($type == "med"){
			$query = $gdb->prepare("SELECT name, medCounter AS counter FROM players ORDER BY medCounter DESC LIMIT 15");
		} elseif ($type == "civ"){
			$query = $gdb->prepare("SELECT name, civCounter AS counter FROM players ORDER BY civCounter DESC LIMIT 15");
		}
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		?>
			<table class="table table-striped">
				<thead>
					<tr> <th>Player</th> <th>Hours</th> </tr>
				</thead>
				<tbody>
					<p>Top 15  players</p>
					<?php
						foreach ($results as $result){
							echo "<tr><td>" . $result['name'] . "</td><td>". playtimeToRealtime($result['counter']) . "</td></tr>";
						}
					?>
					<tr> <td></td> <td></td> </tr>
				</tbody>
			</table>
		<?php
	}
}
?>