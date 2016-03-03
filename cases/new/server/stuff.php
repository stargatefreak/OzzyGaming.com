<?php   
   try {
	   $rootPage = "http://web.ozzygaming.com/cases/new";
        $openid = new LightOpenID('web.ozzygaming.com/cases/new');

        // OpenID not trying to do anything
        if(!$openid->mode) {
            if (isset($_GET['page']) && $_GET['page'] == "login") {
                $openid->identity = 'http://steamcommunity.com/openid/?l=english';    // This is forcing english because it has a weird habit of selecting a random language otherwise
                header('Location: ' . $openid->authUrl());
                die();
            }

            if (isset($_GET['page']) && $_GET['page'] == "logout") {
                unset($_SESSION['player']);
                unset($_SESSION['loginTime']);
                unset($_SESSION['loginAddress']);
                $_SESSION['alert'] = array("success","You have been successfully logged out!");
                header("Location: ".$rootPage);
                die();
            }
        // OpenID cancelling action
        } elseif ($openid->mode == 'cancel'){
            $_SESSION['alert'] = array("warning","Login attempt was cancelled... Somehow...");
        // OpenID trying to do something
        } else {
            if($openid->validate()){
                // Login successful
                // Get steam information
                $userlink = $openid->identity;
                $steamid = str_replace("http://steamcommunity.com/openid/id/", "", $userlink);
                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apikey&steamids=$steamid";
                $json= json_decode(file_get_contents($url));
				
				
                
                // Setup storage of information
                $_SESSION['player'] = array(
                    "steamid" => $steamid,
                    "name" => $json->response->players[0]->personaname,
                    "avatarSmall" => $json->response->players[0]->avatar
                );
                $_SESSION['loginTime'] = time();
                $_SESSION['loginAddress'] = $_SERVER['REMOTE_ADDR'];

                $_SESSION['alert'] = array("success","Login Successful.");
                header("Location: ".$rootPage);
                die();
            } else {
                // Error logging in
                unset($_SESSION['player']);
                unset($_SESSION['loginTime']);
                unset($_SESSION['loginAddress']);
                $_SESSION['alert'] = array("warning","Login attempt failed.");
            }
        }

    }catch(ErrorException $e) {
        $_SESSION['alert'] = array("danger","Something went wrong! " . $e->getMessage());
    }
?>