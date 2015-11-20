<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Anyone can access
        $_SESSION['alert'] = array("warning","You must be at least Helpdesk to access that page.");
        header("Location: ".$rootPage);
        die();
    };

    $renewTime = 60*5; //5 minutes
    if (file_exists("cache/killlog.json")){
        $json = file_get_contents("cache/killlog.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            genKillLog($gdb);
        }
    } else {
        genKillLog($gdb);
    }

    $json = file_get_contents("cache/killlog.json");
    $data = json_decode($json, true);

    echo '<h1>OzzyGaming AltisLife Kill Log</h1>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';

    // Pagnation stuff
    $numRowsPerPage = 200;
    $numPages = ceil(count($data['data'])/$numRowsPerPage);
?>
    <table id="killLogTable" style="width: 100%; font-size: 12px;" class="table table-striped table-hover"><thead>
        <tr> <th>Date</th> <th>Killer</th> <th>Victim</th> <th>Weapon</th> </tr>
        </thead><tbody>
<?php
    $cnt = count($data['data']) > $numRowsPerPage ? $numRowsPerPage : count($data['data']) ;

    for ($i=0; $i < $cnt; $i++) { 
        $entry = $data['data'][$i];
        // CSS for suicide/unknown weapon
        $css = "font-style: italic; color: #999; font-size: smaller;";

        // Unknown weapon catch
        if ($entry['weapon'] == ""){
            $wep = '<span style="'.$css.'">Unknown</span>';
        } else {
            $wep = $entry['weapon'];
        }

        // Suicide detection
        if ($entry['victim'] == "" && $entry['victimLocation'] == ""){
            $vic = '<span style="'.$css.'">None (Suicide)</span>';
        } else {
            $vic = $entry['victimName'].' <span style="font-size: smaller;">(Gridref: '.$entry['victimLocation'].')</span>';
        }

        // Data printing
        echo '<tr> <td>'.$entry['time'].'</td> <td>'.$entry['killerName'].' <span style="font-size: smaller;">(Gridref: '.$entry['killerLocation'].')</span></td> <td>'.$vic.'</td> <td>'.$wep.'</td> </tr>';
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

                    // Unknown weapon catch
                    if (data[i]['weapon'] == ""){
                        var wep = '<span style="'+css+'">Unknown</span>';
                    } else {
                        var wep = data[i]['weapon'];
                    }

                    // Suicide detection
                    if (data[i]['victimName'] == "" && data[i]['victimLocation'] == ""){
                        var vic = '<span style="'+css+'">None (Suicide)</span>';
                    } else {
                        var vic = data[i]['victimName']+' <span style="font-size: smaller;">(Gridref: '+data[i]['victimLocation']+')</span>';
                    }

                    tab.append('<tr> <td>'+data[i]['time']+'</td> <td>'+data[i]['killerName']+' <span style="font-size: smaller;">(Gridref: '+data[i]['killerLocation']+')</span></td> <td>'+vic+'</td> <td>'+wep+'</td> </tr>');
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


    function genKillLog($gdb){
        $query = $gdb->prepare("SELECT * FROM logaction WHERE action = '\"killed\"' ORDER BY time DESC LIMIT 10000");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $output = array('timestamp'=>null, 'data'=>array());
        if (count($result) != 0){
            foreach ($result as $log) {
                $str = $log['info'];
                // Get killer, victim and weapon
                // ^\"(.+) killed (.+) with ([^.]*)\. .+ was at \[[\d.\-,]+\] \((\d+)\)\. .+ was at \[[\d.\-,]+\] \((\d+)\)
                /*preg_match("/^\"(.+) killed .+ with .*\. .+/", $str, $killer);
                preg_match("/^\".+ killed (.+) with .*\. .+/", $str, $victim);
                preg_match("/^\".+ killed .+ with ([a-zA-Z0-9_]*)\. .+/", $str, $weapon);
                
                preg_match("/".escapeRegexChars($killer[1])." was at \[[\-0-9,\.]+\] \((\d+)\)/", $str, $killerLocation);
                preg_match("/".escapeRegexChars($victim[1])." was at \[[\-0-9,\.]+\] \((\d+)\)/", $str, $victimLocation);
                
                // Killer Data
                $killer = $killer[1];
                $killerLocation = $killerLocation[1];

                // Victim Data
                if ($victim[1] == "themselves" && count($victimLocation) != 2){
                    $victim = "";
                    $victimLocation = "";
                } else {
                    $victim = $victim[1];
                    $victimLocation = $victimLocation[1];
                }

                // Weapon Data
                $weapon = $weapon[1];*/

                // 0 - whole match, 1 - killer, 2 - victim, 3 - weapon, 4 - killer location, 5 - victim location
                preg_match("/^\"(.+) killed (.+) with ([^.]*)\. .+ was at \[[\d.\-,]+\] \((\d+)\)\.(?: .+ was at \[[\d.\-,]+\] \((\d+)\))?/", $str, $matches);

                if ($matches[2] == "themselves" && count($matches) != 6){
                    $victim = "";
                    $victimLocation = "";
                } else {
                    $victim = $matches[2];
                    $victimLocation = $matches[5];
                }

                $output['data'][] = array(
                        "time" => $log['time'],
                        "killerId" => trim($log['player'], '"'),
                        "killerName" => $matches[1],
                        "killerLocation" => $matches[4],
                        "victimName" => $victim,
                        "victimLocation" => $victimLocation,
                        "weapon" => $matches[3]
                    );
            }
        }

        $output['timestamp'] = time();
        $json = json_encode($output);
        file_put_contents('cache/killlog.json', $json);
    }

	
	function escapeRegexChars($str){
		$st = $str;
		$st = str_replace('(','\(',$st);
		$st = str_replace(')','\)',$st);
		$st = str_replace('[','\[',$st);
		$st = str_replace(']','\]',$st);
		return $st;
	}
?>