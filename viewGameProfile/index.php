<?php
	SESSION_START();
	date_default_timezone_set("Australia/Sydney");
error_reporting(E_ALL);
ini_set('display_errors', 1);
	require_once("../../scripts/gamedb.php");
	require_once("functions.php");
	
	// Sanity Checks
	if (isset($_POST['search']) && trim($_POST['search']) == ""){
		unset($_POST['search']);
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>OzzyGaming Profile Viewer</title>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/style.css">
		
	</head>
	<body>
		<div id="header">
			<h1>OzzyGaming Profile Viewer</h1>
		</div>
		
		<div id="content">
			<div class="col-md-9">
				<?php
					// Name Conversions
					$copRank = array(0=>"Public","Student","Probationary Constable","Constable","Senior Constable","Leading Senior Constable","Sergeant","Incremental Sergeant","Senior Sergeant","Inspector","Chief Inspector","Superintendent","Chief Superintendent",20=>"Starred Officer (Multiple Ranks)");
					$copPilotRank = array(0=>"Not a pilot.","Pilot Trainee","Pilot","Senior Pilot");
					$medRank = array(0=>"Not a medic.","Medical Technician","Paramedic","Intensive Care Paramedic","Paramedic Instructor","Medical Administration (Multiple Ranks)");
					
					// Player Selected
					if(isset($_POST['pid']) || isset($_SESSION['pid'])) {
						$query = $gdb->prepare("SELECT name, playerid, coplevel, copPilotLevel, copPilotGrounded, mediclevel, medicPilotGrounded, copBlacklist, medicBlacklist, copCounter, medCounter, civCounter, firstjoined, lastonline, copDept FROM players WHERE playerid = :id LIMIT 1");
						$query->bindValue(":id",$_POST['pid']);
						$query->execute();
						
						$results = $query->fetchAll(PDO::FETCH_ASSOC);
						if (count($results) != 0){
							$result = $results[0];
							$copDept = $result['copDept'];
							
							// Setup Player Array
							$player = array(
								"name" => $result['name'],
								"lastonline" => $result['lastonline'],
								"firstjoined" => substr($result['firstjoined'],0,10) == "2014-11-01" ? "Prior to join-logging (2014-11-01)" : $result['firstjoined'],
								
								"copRank" => array_key_exists($result['coplevel'], $copRank) ? ($copRank[$result['coplevel']]) : ("Unknown Rank - " . $result['coplevel'] ),
								"copPilotRank" => $copPilotRank[$result['copPilotLevel']] ? ($copPilotRank[$result['copPilotLevel']]) : ("Unknown Rank - " . $result['copPilotLevel']),
								"copGrounded" => $result['copPilotGrounded'] == '1' ? "Yes" : "No",
								"copBlacklist" => $result['copBlacklist'] == '1' ? "Yes" : "No",
								"copUndercover" => stristr($copDept,'u') == true ? "Yes" : "No",
								"copSPG" => stristr($copDept,'s') == true ? "Yes" : "No",
								
								"medicRank" => array_key_exists($result['mediclevel'], $medRank) ? ($medRank[$result['mediclevel']]) : ("Unknown Rank - " . $result['mediclevel'] ),
								"medicGrounded" => $result['medicPilotGrounded'] == '1' ? "Yes" : "No",
								"medicBlacklist" => $result['medicBlacklist'] == '1' ? "Yes" : "No",
								
								"copTime" => playtimeToRealtime($result['copCounter']),
								"civTime" => playtimeToRealtime($result['civCounter']),
								"medTime" => playtimeToRealtime($result['medCounter']),
								"totalTime" => playtimeToRealtime((string) ((float) $result['copCounter'] + (float) $result['civCounter'] + (float) $result['medCounter']))
							);
							
							// Just for fun... Logging
							file_put_contents("search_log.log",($_SERVER['REMOTE_ADDR'] . " @ " . date("r") . ": Searched for user " . $player['name'] . " (" . $result['playerid'] . ")\n"),FILE_APPEND);
						} else {
							echo "ERROR: No player found.";
						}
						
						if (isset($player) && count($player) != 0){
					?>
					
					<a href="/viewGameProfile/">&lt; New Search</a>
					<h3>Player Information for player: <?php echo $player['name']; ?></h3>
					
					<div id="tabs">
						<ul>
							<li><a href="#tabs-gen">General Info</a></li>
							<li><a href="#tabs-cop">Police Info</a></li>
							<li><a href="#tabs-med">Medic Info</a></li>
							<li><a href="#tabs-civ">Civilian Info</a></li>
						</ul>
						<div id="tabs-gen">
							<table class="table table-striped">
								<tbody>
									<tr><td>Player Name</td><td><?php echo $player['name'];?></td></tr>
									<tr><td>Last Online</td><td><?php echo $player['lastonline'] . " (" . getTimeAgo($player['lastonline']) . " ago)";;?></td></tr>
									<tr><td>First Joined</td><td><?php echo $player['firstjoined'];?></td></tr>
									<tr><td>Total Playtime</td><td><?php echo $player['totalTime']?></td></tr>
								</tbody>
							</table>
						</div>
						<div id="tabs-cop">
							<table class="table table-striped">
								<tbody>
									<tr><td>Police Rank</td><td><?php echo $player['copRank'];?></td></tr>
									<tr><td>Pilot Rank</td><td><?php echo $player['copPilotRank'];?></td></tr>
									<tr><td>Undercover: </td><td><?php echo $player['copUndercover'];?></td></tr>
									<tr><td>SPG:</td><td><?php echo $player['copSPG'];?></td></tr>
									
									<tr><td>Grounded?</td><td><?php echo $player['copGrounded'];?></td></tr>
									<tr><td>Blacklisted?</td><td><?php echo $player['copBlacklist'];?></td></tr>
									
									<tr><td>Playtime</td><td><?php echo $player['copTime'];?></td></tr>
								</tbody>
							</table>
						</div>
						<div id="tabs-med">
							<table class="table table-striped">
								<tbody>
									<tr><td>Medic Rank</td><td><?php echo $player['medicRank'];?></td></tr>
									
									<tr><td>Grounded?</td><td><?php echo $player['medicGrounded'];?></td></tr>
									<tr><td>Blacklisted?</td><td><?php echo $player['medicBlacklist'];?></td></tr>
									
									<tr><td>Playtime</td><td><?php echo $player['medTime'];?></td></tr>
								</tbody>
							</table>
						</div>
						<div id="tabs-civ">
							<table class="table table-striped">
								<tbody>
									<tr><td>Playtime</td><td><?php echo $player['civTime'];?></td></tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<?php
						}
					} elseif(isset($_POST['search'])){
						
						$query = $gdb->prepare("SELECT name, playerid, coplevel, mediclevel, lastonline FROM players WHERE playerid LIKE :search OR name LIKE :search ORDER BY lastonline DESC LIMIT 101");
						$query->bindValue(":search", "%".$_POST['search']."%");
						$query->execute();
						
						$results = $query->fetchAll(PDO::FETCH_ASSOC);
				?>
						<a href="/viewGameProfile/">&lt; New Search</a>
						<form method="POST">
						<input type="submit" value="Grab Player Stats" />
							<table class="table table-striped">
								<thead>
									<tr> <th style="width: 20px;"></th> <th style="width: 300px;">Player Name</th>  <th style="width: 200px;">Last Online</th>  <th style="width: 150px;">Rank Summary</th>  <th style="width: 50px;">Select</th> </tr>
								</thead>
								<tbody>
				<?php
						$first = " checked";
						$num = 1;
						foreach($results as $item){
							if ($num > 100){
								echo "<tr><td colspan=\"5\" style=\"text-align: center;\">There are more then 100 players returned. Only the last 100 to log into the server have been displayed.</td></tr>";
								break;
							}
							
							$rankInfo = "<span class=\"ttip\" title=\"". ( array_key_exists($item['coplevel'], $copRank) ? ($copRank[$item['coplevel']]) : ("Unknown Rank - " . $item['coplevel'] ) ) ."\">Cop: ". $item['coplevel'] ."</span> / ";
							$rankInfo = $rankInfo . "<span class=\"ttip\" title=\"". ( array_key_exists($item['mediclevel'], $medRank) ? ($medRank[$item['mediclevel']]) : ("Unknown Rank - " . $item['mediclevel'] ) ) ."\">Medic: ". $item['mediclevel'] ."</span> / ";
							
							echo "<tr><td><label for=\"".$num."\">".$num."</label></td><td><label for=\"".$num."\">".$item['name']."</label></td><td><label for=\"".$num."\">". getTimeAgo($item['lastonline']) ." ago</label></td><td><label for=\"".$num."\">".$rankInfo."</label></td><td><input type=\"radio\" name=\"pid\" id=\"".$num."\" value=\"". $item['playerid'] ."\" ".$first."></td></tr>";
							$first = "";
							$num = $num + 1;
						}
				?>
								</tbody>
							</table>
						<input type="submit" value="Grab Player Stats" />
						</form>
				<?php
						
					} else {
				?>
				<p>Welcome to the OzzyGaming profile viewer.<br />
				In order to proceed, please enter a name or player ID.<br /><br />
				This utility tool does wildcard matching, meaning that you CAN enter a partial name or ID. eg. "hri" will match "chris" and "ahri" etc</p><br />
				<form method="POST">
					Enter name or steam64/player ID:<br />
					<input type="text" name="search" style="width: 300px;"/><br /><br />
					<input type="submit" value="Find player!" style="width: 140px; height: 40px;" />
				</form>
				<?php
					}
				?>
			</div>
			<div class="col-md-3">
				<div id="statTabs" style="font-size: 10px;">
					<ul>
						<li><a href="#stats">Statistics</a></li>
						<li><a href="#copHourStats">Cop Hours</a></li>
						<li><a href="#medHourStats">Med Hours</a></li>
						<li><a href="#civHourStats">Civ Hours</a></li>
					</ul>
					<div id="stats">
						<?php genStats("general",$gdb); ?>
					</div>
					<div id="copHourStats">
						<?php genStats("cop",$gdb); ?>
					</div>
					<div id="medHourStats">
						<?php genStats("med",$gdb); ?>
					</div>
					<div id="civHourStats">
						<?php genStats("civ",$gdb); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div style="clear: both;">&nbsp;</div>
		
		<div id="footer">
			<p>Please note: All data here is what appears on the database. If you have been promoted recently, ranks may not be correct.<br />&copy; OzzyGaming.com. Design by Kieran.</p>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		
		<script>
			$(function() {
				$( "#tabs" ).tabs();
				$( "#statTabs" ).tabs();
				$( ".ttip" ).tooltip();
				
			});
		</script>
	</body>
</html>