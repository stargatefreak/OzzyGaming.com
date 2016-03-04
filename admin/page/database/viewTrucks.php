<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Team can access
        $_SESSION['alert'] = array("warning","That tool is only available to Helpdesk members.");
        header("Location: ".$rootPage."/?page=database");
        die();
    };
    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/trucks.json")){
        $json = file_get_contents("cache/trucks.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenLog($gdb);
        }
    } else {
        regenLog($gdb);
    }

    $json = file_get_contents("cache/trucks.json");
    $data = json_decode($json, true);

    echo '<h3>Truck Mission Log</h3>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
<table id="nameTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover">
    <thead>
        <tr> <th>Date</th> <th>Player</th> <th>Type</th> <th>GridRef</th> <th>Deliver/Retrieve</th>  </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<nav style="margin-left: auto; margin-right: auto; text-align: center;">
    <ul class="pagination">
    </ul>
</nav>

<script>
    var currentPage = 1;
    var numPages = <?php echo $numPages; ?>;
    var numRowsPerPage = <?php echo $numRowsPerPage; ?>;
    var cacheData = <?php echo json_encode($data['data']); ?>;

    function redrawTable(){
        var startEntry = (currentPage-1) * numRowsPerPage;
        var endEntry = startEntry + numRowsPerPage;
        var data = cacheData.slice( startEntry , endEntry );
		tab.html("");
		for (var i = 0; i < data.length; i++) {
			var truckType = "";
			switch (data[i]['type']){
				case "ILLEGAL":
					truckType += '<span style="color: #F00">Illegal</span>';
					break;
				case "LEGAL":
					truckType += '<span style="color: #0F0">Legal</span>';
					break;
				default:
					truckType += '<span style="color: #00F">Unknown</span>';
					break;
			}
			switch (data[i]['option']){
				case "started":
					var option = '<span style="color: #00F">Started</span>'
				case "delivered":
					var option = '<span style="color: #00F">Delivered</span>'
			}
                tab.append('<tr> <td>'+data[i]['time']+'</td> <td>'+data[i]['player']+'</td> <td>'+truckType+'</td> <td>'+data[i]['location']+'</td> <td>'+option+'</td> </tr>');
        };
    }
</script>
<script src="js/pagination.js"></script>
<script>
    $( document ).ready(function() {
        redrawTable();
        redrawPagination();
    });
</script>

<?php

    function regenLog($gdb){
        $query = $gdb->prepare("SELECT * FROM logaction WHERE action = '\"delivery\"' ORDER BY time DESC LIMIT 700");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                // 0 - whole message, 1 - player, 2 - type, 3 - location
                preg_match("/\"([\D\d]+) (?:started|delivered) a truck mission \((ILLEGAL|LEGAL)\)\s*(?:for \$\d+)? at [\[\d\,\.\-\]]+ \((\d+)\)\"/i",$log['info'], $matches);

                $output['data'][] = array(
                        "time" => $log['time'],
                        "player" => trim($matches[1]),
                        "type" => trim($matches[3]),
                        "location" => trim($matches[4]),
						"option" => trim($matches[2])
                    );
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/trucks.json', $json);
    }

?>