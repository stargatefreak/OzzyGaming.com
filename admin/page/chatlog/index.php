<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Anyone can access
        $_SESSION['alert'] = array("warning","You must be at least Helpdesk to access that page.");
        header("Location: ".$rootPage);
        die();
    };

    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/chatlog.json")){
        $json = file_get_contents("cache/chatlog.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenChatlog($gdb);
        }
    } else {
        regenChatlog($gdb);
    }

    $json = file_get_contents("cache/chatlog.json");
    $data = json_decode($json, true);

    echo '<h1>OzzyGaming AltisLife Chat Log</h1>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
    <table id="killLogTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover"><thead>
        <tr> <th>Time</th> <th>Sender</th> <th>Channel</th> <th>Message</th> </tr>
        </thead><tbody>
<?php
    $cnt = count($data['data']) > $numRowsPerPage ? $numRowsPerPage : count($data['data']) ;

    for ($i=0; $i < $cnt; $i++) { 
        $entry = $data['data'][$i];
        $css = "font-style: italic; color: #999; font-size: smaller;";

        // Data printing
        echo '<tr> <td>'.$entry['date'].'</td> <td>'.$entry['sender'].'</td> <td>'.$entry['channel'].'</td> <td>'.$entry['message'].'</td> </tr>';
    }
?>
    </tbody></table>
    <nav style="margin-left: auto; margin-right: auto; text-align: center;">
        <ul class="pagination">
        </ul>
    </nav>
    <script>
        var currentPage = 1;
        var numPages = <?php echo $numPages; ?>;
        var numRowsPerPage = <?php echo $numRowsPerPage; ?>;
        var killData = <?php echo json_encode($data['data']); ?>;

        function redrawTable(){
            var startEntry = (currentPage-1) * numRowsPerPage;
            var endEntry = startEntry + numRowsPerPage;
            var data = killData.slice( startEntry , endEntry );
            
            // CSS for suicide/unknown weapon
            var css = "font-style: italic; color: #999; font-size: smaller;";

                tab.html("");
                for (var i = 0; i < data.length; i++) {
					tab.append('<tr> <td>'+data[i]['date']+'</td> <td>'+data[i]['sender']+'</td> <td>'+data[i]['channel']+'</td> <td>'+data[i]['message']+'</td> </tr>');
                };
            }
    </script>
    <script src="js/pagination.js"></script>
    <script>
        $( document ).ready(function() {
           redrawPagination();
        });
    </script>
<?php

	    function regenChatlog(){
        // Grab the base Chats
		include("../../scripts/sftp.php");
		$sftp->get('/home/steam/arma3/ozzy.rpt', 'D:\xampp\scripts\chatlog.txt');
		

		$chats = file("D:/xampp/scripts/chatlog.txt");
		$chats = array_reverse($chats);
		
        foreach ($chats as $log) {				
                if (preg_match("/(\d+:\d+:\d+) \w+ \w+: \((\w+)\) ([\w\s\D\d][^:]+): ([\D]*)/", $log, $matches)){

                $output['data'][] = array(
                        "date" => $matches[1],
                        "channel" => $matches[2],
                        "sender" => $matches[3],
                        "message" => $matches[4]
                );
				}
        }
		$output['timestamp'] = time();
		$json = json_encode($output);
        file_put_contents('cache/chatlog.json', $json);

		}

?>