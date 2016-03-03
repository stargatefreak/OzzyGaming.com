<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Team can access
        $_SESSION['alert'] = array("warning","That tool is only available to Helpdesk members.");
        header("Location: ".$rootPage."/?page=database");
        die();
    };
    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/revives.json")){
        $json = file_get_contents("cache/revives.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenLog($gdb);
        }
    } else {
        regenLog($gdb);
    }

    $json = file_get_contents("cache/revives.json");
    $data = json_decode($json, true);

    echo '<h3>Revive Log</h3>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
<table id="nameTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover">
    <thead>
        <tr> <th>Date</th> <th>Reviver</th> <th>Victim</th> <th>GridRef</th> </tr>
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
                tab.append('<tr> <td>'+data[i]['time']+'</td> <td>'+data[i]['reviver']+'</td> <td>'+data[i]['victim']+'</td> <td>'+data[i]['location']+'</td> </tr>');
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
        $query = $gdb->prepare("SELECT * FROM logaction WHERE action = '\"revived\"' ORDER BY time DESC LIMIT 700");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                // 0 - whole message, 1 - reviver, 2 - victim, 3 - location
                preg_match("/\"(.+) revived (.+) at \[[\d.,\-]+\] \((\d+)\)\"/i",$log['info'], $matches);

                $output['data'][] = array(
                        "time" => $log['time'],
                        "reviver" => trim($matches[1]),
                        "victim" => trim($matches[2]),
                        "location" => trim($matches[3])
                    );
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/revives.json', $json);
    }

?>