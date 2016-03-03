<?php
    SESSION_START();

    $secKey = $_POST['secKey'];
    if (!isset($_SESSION['ajaxPlainKey']) || !password_verify($_SESSION['ajaxPlainKey'],$secKey) ){
        die("unauthorised access1");
    }

    if (isset($_POST['bans'])){
        $banlist = $_POST['bans'];
    }
    if (isset($_POST['banType'])){
        $bantype = $_POST['banType'];
    }

    if (!isset($_SESSION['bans'])){
        $_SESSION['bans'] = array("guid"=>array(), "ip"=>array());
    }

    require("../../../scripts/gamedb.php");

    if ($bantype == "done"){
        // Write the file
        $data = $_SESSION['bans'];
        $data = array("timestamp"=>time(),"data"=>$data);
        $data = json_encode($data);
        file_put_contents('../cache/banlist.json', $data);
        // Clear the session variable
        unset($_SESSION['bans']);
    } elseif ($bantype == "ip") {
        // IP Ban, won't have any player data, cause we don't store IPs in the database
        foreach ($banlist as $ban) {
            $_SESSION['bans']['ip'][] = $ban;
        }
    } elseif ($bantype == "guid") {
        // GUID ban, we can get their player information from the database
        // Query for the players
        $numEntries = count($banlist);
        $question = array_fill(0, $numEntries, '?');
        $questions = implode(',', $question);
        $query = $gdb->prepare("SELECT `name`, `guid`, `playerid`, `adminnote`, (`copCounter`+`civCounter`+`medCounter`) AS totalhours, `adminlevel`, `coplevel`, `mediclevel`, `lastonline`, `firstjoined` FROM `arma3life`.`players` WHERE `guid` IN (".$questions.")");
        for ($i=0; $i < count($question); $i++) { 
            $query->bindValue( ($i+1), $banlist[$i]['guid']);
        }
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $bans = array();
        for ($i=0; $i < count($banlist); $i++) {
            // Default values to make things easy
            $banlist[$i]['name'] = '';
            $banlist[$i]['playerid'] = 'No Info';
            $banlist[$i]['adminnote'] = 'No Info';
            $banlist[$i]['lastonline'] = 'No Info';
            $banlist[$i]['firstjoined'] = 'No Info';
            $banlist[$i]['totalhours'] = 'No Info';
            $banlist[$i]['adminlevel'] = 'No Info';
            $banlist[$i]['coplevel'] = 'No Info';
            $banlist[$i]['mediclevel'] = 'No Info';

            foreach ($result as $item) {
                // Make sure the GUIDs are the same
                if ($item['guid'] == $banlist[$i]['guid']){
                    $banlist[$i]['name'] = $item['name'];
                    $banlist[$i]['playerid'] = $item['playerid'];
                    $banlist[$i]['adminnote'] = $item['adminnote'];
                    $banlist[$i]['lastonline'] = $item['lastonline'];
                    $banlist[$i]['firstjoined'] = $item['firstjoined'];
                    $banlist[$i]['totalhours'] = $item['totalhours'];
                    $banlist[$i]['adminlevel'] = $item['adminlevel'];
                    $banlist[$i]['coplevel'] = $item['coplevel'];
                    $banlist[$i]['mediclevel'] = $item['mediclevel'];
                    break;
                }
            }
            // And add the ban to the masterlist
            $_SESSION['bans']['guid'][] = $banlist[$i];
        }
    }
?>