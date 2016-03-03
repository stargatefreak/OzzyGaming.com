<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }

    function printGeneralStats($gdb){
        $renewTime = (60*60* 6); // 6 hours
        
        // Check if relevant cache data exists
        if (file_exists("cache/generalStats.json")){
            // Check if cache data datestamp is within parameters
            $json = file_get_contents("cache/generalStats.json");
            $data = json_decode($json, true);

            // How long can general stats sit before they are considered old?
            if (time() - $data['timestamp'] > $renewTime){
                generateGeneralStats($gdb);
            }
        } else {
            generateGeneralStats($gdb);
        }

        // The file will have been created above, now lets read
        $json = file_get_contents("cache/generalStats.json");
        $data = json_decode($json, true);
?>
        <div class="panel panel-default" style="width: 80%; margin-left: auto; margin-right: auto;">
            <div class="panel-heading">
                <h3 class="panel-title" style="text-align: center;">General Server Stats</h3>
            </div>
            <div class="panel-body">
                <p style="text-align: center; margin-top: -10px;">This data was generated at <strong><?php echo date("h:iA d-M", $data['timestamp']); ?></strong> and will refresh at <strong><?php echo date("h:iA d-M", ($data['timestamp'] + $renewTime)); ?></strong></p>
                <div class="col-md-6">
                    Top 10 players by cash:
                        <?php
                        // Only show this to admins and higher
                        if ($_SESSION['player']['adminLevel'] > 2){
                            echo '<table>';
                            foreach ($data['data']['playerCash'] as $value) {
                                echo '<tr><td style="padding-left: 10px; padding-right: 20px;">'.$value['name'].'</td><td>'.playtimeToRealtime($value['hours']).'</td><td style="padding-left: 20px; padding-right: 10px;">'.formatCash($value['cash']).'</td></tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<p>You must be an administrator or higher to view this data.</p>';
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <br /><table>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Total cash on server</td>          <td><?php echo formatCash($data['data']['totalCash']); ?></td></tr>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Number of players</td>             <td><?php echo formatNumber($data['data']['players']); ?></td></tr>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Number of purchased houses</td>    <td><?php echo formatNumber($data['data']['houses']); ?></td></tr>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Number of alive vehicles</td>      <td><?php echo formatNumber($data['data']['vehicles']['alive']); ?></td></tr>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Number of impounded vehicles</td>  <td><?php echo formatNumber($data['data']['vehicles']['impounded']); ?></td></tr>
                        <tr><td style="padding-left: 10px; padding-right: 20px;">Number of dead vehicles</td>       <td><?php echo formatNumber($data['data']['vehicles']['dead']); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
<?php
    }

    // Function to generate cache data data
    function generateGeneralStats($gdb){
        $data = array();

        // Amount of cash in server
        $query = $gdb->prepare("SELECT (sum(cash)+sum(bankacc)) AS totalCash FROM players");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['totalCash'] = $result['totalCash'];

        // Top 10 people with cash
        $query = $gdb->prepare("SELECT name, (copCounter+medCounter+civCounter) AS totalHours, (cash+bankacc) AS cashAmount FROM players ORDER BY (cash+bankacc) DESC LIMIT 10");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $data['playerCash'] = array();
        foreach ($result as $person) {
            $data['playerCash'][] = array("name"=>$person['name'], "cash"=>$person['cashAmount'], "hours"=>$person['totalHours']);
        }

        // Number of alive/dead/impounded vehicles
        $data['vehicles'] = array();

        $query = $gdb->prepare("SELECT count(*) AS numAliveVehicles FROM vehicles WHERE alive = '1'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['vehicles']['alive'] = $result['numAliveVehicles'];

        $query = $gdb->prepare("SELECT count(*) AS numImpoundVehicles FROM vehicles WHERE alive = '1' AND impounded = '1'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['vehicles']['impounded'] = $result['numImpoundVehicles'];

        $query = $gdb->prepare("SELECT count(*) AS numDeadVehicles FROM vehicles WHERE alive = '0'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['vehicles']['dead'] = $result['numDeadVehicles'];

        // Number of purchased houses
        $query = $gdb->prepare("SELECT count(*) AS numHouses FROM houses");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['houses'] = $result['numHouses'];

        // Number of players
        $query = $gdb->prepare("SELECT count(*) AS numPlayers FROM players");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $data['players'] = $result['numPlayers'];


        // Store in a file in a JSON format
        $json = json_encode(array("timestamp"=>time(), "data"=>$data), JSON_FORCE_OBJECT);
        file_put_contents("cache/generalStats.json", $json);
    }

?>