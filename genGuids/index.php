<?php
	SESSION_START();
	$_SESSION['sec'] = "ks92";
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("../../scripts/gamedb.php");
	$query = $gdb->prepare("SELECT uid, guid, playerid, name FROM players WHERE guid = '' OR guid IS NULL LIMIT 5000");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	
	$max = count($result);
	$arr = json_encode($result);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>OzzyGaming.com genGUID</title>
	</head>
	<body>
		<progress id="pg" value="0" max="<?php echo $max; ?>" style="width: 500px;"></progress> <span id="curr">0</span> / <?php echo $max; ?>
		<div id="info" style=""></div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/core.js"></script>
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/lib-typedarrays.js"></script>
		<script src="http://peterolson.github.com/BigInteger.js/BigInteger.min.js"></script>
		<script type="text/javascript">
			var players = <?php echo $arr; ?>;
			var cnt = 0;
			
			// UID converter function
			var uid2guid = function(uid) {
				if (!uid) {
					return;
				}
				
				var steamId = bigInt(uid);

				var parts = [0x42,0x45,0,0,0,0,0,0,0,0];

				for (var i = 2; i < 10; i++) {
					var res = steamId.divmod(256);
					steamId = res.quotient; 
					parts[i] = res.remainder.toJSNumber();
				}

				var wordArray = CryptoJS.lib.WordArray.create(new Uint8Array(parts));
				var hash = CryptoJS.MD5(wordArray);
				return hash.toString();
			}
			
			var sendData = function(player, guid){
				$.ajax({
					url: 'script.php',
					type: "POST",
					data: {p: player, g: guid},
					cache: false,
					success: function(data, status, xhr){
						$("#info").append("<span>"+data+"</span><br />");
						cnt = cnt + 1;
						
						$("#pg").val(cnt);
						$("#curr").html(cnt);
						
						if (players.length > cnt){
							var guid = uid2guid(players[cnt].playerid);
							sendData(players[cnt], guid);
						} else {
							$("#info").append('<span>Finished!</span>');
						}
					},
					error: function(xhr, status, error){
						$("#info").append("<span style=\"color: #FFF;\">Player "+player.id+" FAILED to be added with GUID "+guid+" - "+ status +"</span>");
					}
				});
			}
			
			$(document).ready(function(){
				if (players.length != 0){
					var guid = uid2guid(players[cnt].playerid);
					sendData(players[cnt], guid);
				} else {
					$("#info").append('<span>No one to process!</span>');
				}
			})
		</script>
	</body>
</html>