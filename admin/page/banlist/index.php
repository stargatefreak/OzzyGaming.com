<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Anyone can access
        $_SESSION['alert'] = array("warning","You must be at least Helpdesk to access that page.");
        header("Location: ".$rootPage);
        die();
    };

    $renewTime = 60*30; //30 minutes
    // Check if banlist exists
    if (file_exists("cache/banlist.json")){
        $json = file_get_contents("cache/banlist.json");
        $data = json_decode($json, true);
        if (time() - $data['timestamp'] > $renewTime){
            regenBanList();
            die();
        }
    } else {
        regenBanList();
        die();
    }

    if (!isset($data)){
        $json = file_get_contents("cache/banlist.json");
        $data = json_decode($json, true);
    }
    echo '<h1>OzzyGaming AltisLife Ban List</h1>';
    echo '<p>This data was generated at <strong>'.date("h:iA d-M", $data['timestamp']).'</strong> and will refresh at <strong>'.date("h:iA d-M", ($data['timestamp'] + $renewTime)).'</strong></p>';
    printBanList($data);


    function printBanList($data){
        // Jquery UI Tabs to separate GUID and IP bans
		echo '<p>There are a total of '.count($data['data']['guid']).' GUID bans and '.count($data['data']['ip']).' IP bans.</p>';
?>
<div id="bantabs">
    <ul><li><a href="#tabs-guid">GUID Bans</a></li>
        <li><a href="#tabs-ip">IP Bans</a></li></ul>

    <div id="tabs-guid">
        <table style="width: 100%" class="table table-striped table-hover">
            <thead>
                <tr><th>GUID</th><th>Expiry</th><th>Name</th><th>Reason</th><th>More Info</th></tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                    foreach ($data['data']['guid'] as $ban) {
                        $extra  = "Player ID: " . $ban['playerid'] . "<br />";
                        $extra .= "Admin note: " . $ban['adminnote'] . "<br />";
                        $extra .= "Total Hours: " . $ban['totalhours'] . "<br />";
                        $extra .= "Last Online: " . $ban['lastonline'] . "<br />";
                        $extra .= "First Joined: " . $ban['firstjoined'] . "<br />";
                        $extra .= "Admin Level: " . $ban['adminlevel'] . "<br />";
                        $extra .= "Police Level: " . $ban['coplevel'] . "<br />";
                        $extra .= "Medic Level: " . $ban['mediclevel'];

                        echo '<tr> <td style="width: 15%">'.$ban['guid'].'</td>';
                        echo      '<td style="width: 20%">'.$ban['expiry'].'</td>';
                        echo      '<td style="width: 10%">'.$ban['name'].'</td>';
                        echo      '<td style="width: 35%">'.$ban['reason'].'</td>';
                        echo      '<td style="width: 20%; font-size:10px;" class="moreinfo"><p class="clickToggle" style="cursor: pointer; color: #009;">Click to toggle information.</p><div>'.$extra.'</div></td> </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div id="tabs-ip">
        <table style="width: 100%" class="table table-striped table-hover">
            <thead>
                <tr><th>IP</th><th>Expiry</th><th>Reason</th></tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                    foreach ($data['data']['ip'] as $ban) {
                        echo '<tr> <td>'.$ban['ip'].'</td> <td>'.$ban['expiry'].'</td> <td>'.$ban['reason'].'</td> </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $( "#bantabs" ).tabs();
        $(".moreinfo div").addClass("collapse");
    });

    $('#tabs-guid table tbody p.clickToggle').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $collapse = $this.parent().find('div');
        $collapse.collapse('toggle');
    });
</script>
<?php
    }


    function regenBanList(){
        // Grab the base banlist
        $guids = file("D:\\ozzygamingservices\\armatest\\battleye\\bans.txt");

		// Grabs the bas banlist from SFTP conection
		
		//include("../../scripts/sftp.php");

		//$sftp->get('/home/steam/arma3/battleye/bans.txt', 'D:\xampp\scripts\banlist.txt');
		

		//$guids = file("D:/xampp/scripts/banlist.txt");
		
        $guidbans = array();
        $ipbans = array();
        foreach ($guids as $id){
            $parts = explode(" ", $id, 3);

            // Check the expiry and format it
            if ($parts[1] == "-1"){
                $expiry = "Permanent";
            } else {
                $expiry = date("Y/m/d h:i a",$parts[1]);
            }

            //Split up IP bans and GUID bans
            if (preg_match("/\d+\.\d+\.\d+\.\d+/i",trim($parts[0])) == 0){                          
                $ban = array(
                    "guid" => $parts[0],
                    "expiry" => $expiry,
                    "reason" => trim($parts[2])
                );
                array_push($guidbans, $ban);
            } else {
                $ban = array(
                    "ip" => $parts[0],
                    "expiry" => $expiry,
                    "reason" => trim($parts[2])
                );
                array_push($ipbans, $ban);
            }
        }
?>
    <p style="text-align: center; margin-top: 5em;">Generating ban list and crunching data...<br />Please be patient, this may take some time!</p>
    <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span style="color: #000;">&nbsp;0%</span></div></div>
    <p style="text-align: center;" id="banlistAlertField"></p>

    <script>
        var secKey = '<?php echo $_SESSION['ajaxCryptKey']; ?>';
        var ipbans = <?php echo json_encode($ipbans); ?>;
        var guidbans = <?php echo json_encode($guidbans); ?>;
    </script>
    <script src="js/banlist.js"></script>
    <script>
    getBanData();
    </script>
<?php 
    }
?>