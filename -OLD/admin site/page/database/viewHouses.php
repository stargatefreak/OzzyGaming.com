<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 3){
        // Team can access
        $_SESSION['alert'] = array("warning","That tool is only available to Admins.");
        header("Location: ".$rootPage."/?page=database");
        die();
    };
    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/houseLog.json")){
        $json = file_get_contents("cache/houseLog.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenMessages($gdb);
        }
    } else {
        regenMessages($gdb);
    }

    $json = file_get_contents("cache/houseLog.json");
    $data = json_decode($json, true);

    echo '<h3>House Interaction Log</h3>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
<p>Please note: Formatting being fixed up later</p>
<table id="nameTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover">
    <thead>
        <tr> <th>Date</th> <th>Player</th> <th>Action</th> <th>Owner</th> <th>Location</th> </tr>
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
                tab.append('<tr> <td>'+data[i]['time']+'</td> <td>'+data[i]['player']+'</td> <td>'+data[i]['action']+'</td> <td>'+data[i]['owner']+'</td> <td>'+data[i]['location']+'</td> </tr>');
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

    function regenMessages($gdb){
        $query = $gdb->prepare("SELECT * FROM logaction WHERE action = 'house' ORDER BY time DESC LIMIT 10000");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                // 0 - whole message, 1 - player, 2 - action, 3 - house Owner, 4 - house location
                $action = "unknown";

                print_r(preg_match("/\"(.+) (bought a|sold their) house at \[[\d\-\.,]+\] \((\d+)\)/i",$log['info'], $matches));
                //%1 bought a house at %2 (%3)
                //%1 sold their house at %2 (%3)
                if ( preg_match("/\"(.+) (bought a|sold their) house at \[[\d\-\.,]+\] \((\d+)\)/i",$log['info'], $matches) ){
                    switch ($matches[2]){
                        case "bought a":
                            $action = "Purchased";
                            break;
                        case "sold their":
                            $action = "Sold";
                            break;
                    }

                //%1 broke down door of %2's house at %3 (%4)
                //%1 broke into %2's house at %3 (%4)
                //%1 checked owner of %2's house at %3 (%4)
                //%1 searched %2's house at %3 (%4)
                } elseif (preg_match("/\"(.+) (broke down door of|broke into|checked owner of|searched) (.+)'s house at \[[\d\-\.,]+\] \((\d+)\)/i",$log['info'], $matches) ){
                    switch ($matches[2]){
                        case "broke down door of":
                            $action = "Cop Breakin";
                            break;
                        case "broke into":
                            $action = "Civ Breakin";
                            break;
                        case "checked owner of":
                            $action = "Cop Ownercheck";
                            break;
                        case "searched":
                            $action = "Cop Searched";
                            break;
                    }
                } else {
                    $matches = array("","","","","");
                }

                $output['data'][] = array(
                        "time" => $log['time'],
                        "player" => trim($matches[1]),
                        "action" => $action,
                        "owner" => $matches[3],
                        "location" => $matches[4]
                    );
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/houseLog.json', $json);
    }

?>