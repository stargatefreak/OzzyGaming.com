<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Team can access
        $_SESSION['alert'] = array("warning","That tool is only available to Helpdesk members.");
        header("Location: ".$rootPage."/?page=database");
        die();
    };
    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/cellphoneMessages.json")){
        $json = file_get_contents("cache/cellphoneMessages.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenMessages($gdb);
        }
    } else {
        regenMessages($gdb);
    }

    $json = file_get_contents("cache/cellphoneMessages.json");
    $data = json_decode($json, true);

    echo '<h3>Cellphone Message Log</h3>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
<table id="nameTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover">
    <thead>
        <tr> <th style="width: 20%">Date</th> <th style="width: 15%">Sender</th> <th style="width: 15%">Receiver</th> <th style="width: 50%">Message</th> </tr>
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
                // Just confirm the receiver, make sure it's not someone with the name 'the police' etc
                switch (data[i]['messageType']){
                    case "player":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'">'+data[i]['sender']+'</td> <td title="Coords: '+data[i]['receiverCoords']+'">'+data[i]['receiver']+'</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                    case "topolice":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'">'+data[i]['sender']+'</td> <td style="color: #00F;">Police</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                    case "tomedic":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'">'+data[i]['sender']+'</td> <td style="color: #090;">Paramedics</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                    case "toadmin":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'">'+data[i]['sender']+'</td> <td style="color: #F00;">Admins</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                    case "admintoplayer":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'" style="color: #F00">'+data[i]['sender']+'</td> <td title="Coords: '+data[i]['receiverCoords']+'">'+data[i]['receiver']+'</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                    case "admintoserver":
                        tab.append('<tr> <td>'+data[i]['time']+'</td> <td title="Coords: '+data[i]['senderCoords']+'" style="color: #F00">'+data[i]['sender']+'</td> <td style="color: #F00">The Server</td> <td>'+data[i]['message']+'</td> </tr>');
                        break;
                }
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
        $query = $gdb->prepare("SELECT * FROM messages ORDER BY time DESC LIMIT 10000");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                if (trim(trim($log['receivingPlayer'],'"')) == 'server') {
                    // 0 - whole message, 1 - sender, 2 - sender coords
                    preg_match("/\"?(.+) at \[[\d\-\.,]+\] \((\d+)\) adminmessaged globally\"?/i",$log['info'], $matches);

                    $output['data'][] = array(
                            "time" => $log['time'],
                            "sender" => trim(trim($matches[1],'"')),
                            "receiver" => "",
                            "message" => trim(trim($log['message'],'"')),
                            "senderCoords" => trim(trim($matches[2],'"')),
                            "receiverCoords" => "",
                            "messageType" => "admintoserver",
                        );
                } else {
                    // 0 - whole message, 1 - sender, 2 - sender coords, 3 - message type, 4 - receiver, 5 - receiver coords
                    preg_match("/\"?(.+) at \[[\d\-\.,]+\] \((\d+)\) ((?:admin)?messaged) (.+) at \[[\d\-\.,]+\] \((\d+)\)\"?/i",$log['info'], $matches);

                    $type = "";
                    if (trim(trim($matches[3],'"')) == "messaged"){
                        if (trim(trim($log['receivingPlayer'],'"')) == "police"){
                            $type = "topolice";
                        } elseif (trim(trim($log['receivingPlayer'],'"')) == "medic"){
                            $type = "tomedic";
                        } elseif (trim(trim($log['receivingPlayer'],'"')) == "admin") {
                            $type = "toadmin";
                        } else {
                            $type = "player";
                        }
                    } elseif(trim(trim($matches[3])) == "adminmessaged"){
                        $type = "admintoplayer";
                    }

                    $output['data'][] = array(
                            "time" => $log['time'],
                            "sender" => trim(trim($matches[1],'"')),
                            "receiver" => trim(trim($matches[4],'"')),
                            "message" => trim(trim($log['message'],'"')),
                            "senderCoords" => trim(trim($matches[2],'"')),
                            "receiverCoords" => trim(trim($matches[5],'"')),
                            "messageType" => $type,
                        );
                }
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/cellphoneMessages.json', $json);
    }

?>