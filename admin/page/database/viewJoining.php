<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Team can access
        $_SESSION['alert'] = array("warning","That tool is only available to Helpdesk members.");
        header("Location: ".$rootPage."/?page=database");
        die();
    };
    $renewTime = 1; //5 minutes
    if (file_exists("cache/joinlog.json")){
        $json = file_get_contents("cache/joinlog.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenLog($gdb);
        }
    } else {
        regenLog($gdb);
    }

    $json = file_get_contents("cache/joinlog.json");
    $data = json_decode($json, true);

    echo '<h3>Joining & Leaving Log</h3>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
<table id="nameTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover">
    <thead>
        <tr> <th>Date</th> <th>Player</th> <th>Action</th> <th>Gridref</th> </tr>
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
                if (data[i]['faction'] != ''){
                    var fac = "Joined ";
					var pos = "N/A"
                    switch (data[i]['faction']){
                        case "Civilian":
                            fac += '<span style="color: #F00">Civilian</span>';
                            break;
                        case "Cop":
                            fac += '<span style="color: #00F">Police</span>';
                            break;
                        case "Medic":
                            fac += '<span style="color: #0F0">Medic</span>';
                            break;
                        default: 
                            var fac = data[i]['manner'];
                            var pos = data[i]['faction'];
                    }
                } else {
                    var fac = data[i]['manner'];
                }
				
                tab.append('<tr> <td>'+data[i]['time']+'</td> <td>'+data[i]['player']+'</td> <td>'+fac+'</td> <td>'+pos+'</td> </tr>');
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
        $query = $gdb->prepare("SELECT * FROM logaction WHERE action = '\"joined\"' OR action = '\"abort\"' ORDER BY time DESC LIMIT 10000");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                // 0 - whole message, 1 - player, 2 - faction
                preg_match("/\"(.+) (joined|aborted) [\w\s]+? (?:as|from)[\[\d\.\,\]\s]+(?:\()?(\w+)?(\d+)?(?:\))?\"/i",$log['info'], $matches);
				
				if (strpos($log['info'], 'unusual manner') !== false) {
					$manner = 'Left in unusual manner'
				} else {
					$manner = 'Left the server'
				}
                $output['data'][] = array(
                        "time" => $log['time'],
                        "player" => trim($matches['1']),
						"faction" =>  trim($matches['3'])
						"manner" => $manner
                    );
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/joinlog.json', $json);
    }

?>