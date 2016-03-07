<?php
    SESSION_START();
    date_default_timezone_set("Australia/Sydney");
	echo "<title>OzzyGaming.com Admin Tools</title>";
    // Some variables to be accessed by all included pages
    $rootPage = "http://web.ozzygaming.com/admin";
    $ranks = array(1=>"Helpdesk",2=>"Moderator",3=>"Administrator",4=>"Server Administrator",5=>"Server Manager",6=>"Server Executive");
    // Security Variables
    $sec = "para92qasozzy"; // Used by anything included
    $_SESSION['ajaxPlainKey'] = rand()*rand(); // Used by ajax pages
    $_SESSION['ajaxCryptKey'] = password_hash($_SESSION['ajaxPlainKey'], PASSWORD_DEFAULT); // passed to ajax pages

    // Page Requires
    require("server/apikey.php");
    require("server/openid.php");
    require("server/helper.php");
    require("../../scripts/gamedb.php");

    try {
        $openid = new LightOpenID('web.ozzygaming.com');

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

                // Get gameDB information
                $query = $gdb->prepare("SELECT `adminlevel`, `name` FROM `arma3life`.`players` WHERE `playerid` = :id");
                $query->bindValue(":id",$steamid);
                $query->execute();
                $result = $query->fetchall(PDO::FETCH_ASSOC);

                $rank = 0;
                if (count($result) == 1) {
                    $rank = (int)$result[0]['adminlevel'];
                    $name = $result[0]['name'];
                }
                
                // Setup storage of information
                $_SESSION['player'] = array(
                    "steamid" => $steamid,
                    "name" => $json->response->players[0]->personaname,
                    "igName" => $name,
                    "avatarSmall" => $json->response->players[0]->avatar,
                    "adminLevel" => $rank
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

    // Check for login on admin pages
    if (isset($_GET["page"]) && !in_array($_GET["page"], array("login","logout","home")) ){
        // Check for sessions being set (logged in)
        if ( !isset($_SESSION["player"]) || !isset($_SESSION["player"]["steamid"]) || !isset($_SESSION["player"]["name"]) || !isset($_SESSION["player"]["adminLevel"]) || !isset($_SESSION["loginTime"]) || !isset($_SESSION["loginAddress"]) ){
            $_SESSION['alert'] = array("warning","You must be logged in to access that page.");
            header("Location: ".$rootPage);
            die();
        }

        if ( (time() - $_SESSION['loginTime'] > 86400) || ($_SERVER['REMOTE_ADDR'] != $_SESSION['loginAddress']) ){
            $_SESSION['alert'] = array("warning","Session expired. Please log in again. " . ($_SESSION['player']['loginTime']) . " || " . (time()) );
            unset($_SESSION['player']);
            unset($_SESSION['loginTime']);
            unset($_SESSION['loginAddress']);
            header("Location: ".$rootPage);
            die();
        }

        if ($_SESSION['player']['adminLevel'] == 0) {
            $_SESSION['alert'] = array("warning","You must be an OzzyGaming Team Member to access that page.");
            header("Location: ".$rootPage);
            die();
        }
    }

if (isset($_SESSION['player']) && isset($_SESSION['player']['name'])){
    if (isset($_GET['page']) && $_GET['page'] != 'home'){
        file_put_contents('pagedata.txt', $_SESSION['player']['name'].' ('.$_SESSION['player']['igName'].') accessed page '.$_GET['page'].' at '.Date("d/m/Y h:m a").'.'.PHP_EOL, FILE_APPEND);
    }
}
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(window).resize(function() {
                var height = $("nav.navbar").outerHeight(true);
                $("body").css("padding-top", height+"px");
            });
        </script>
    </head>
    <body>
        <!-- Navbar Start -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">OG Admin Tools</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li<?php if(!isset($_GET['page']) || !in_array($_GET['page'],array("itemscan","database","banlist","chatlog","rcon"))){echo ' class="active"';} ?>><a href="?">Home</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="itemscan"){echo ' class="active"';} ?>><a href="?page=itemscan">Item Scan</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="database"){echo ' class="active"';} ?>><a href="?page=database">DB Tools</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="banlist"){echo ' class="active"';} ?>><a href="?page=banlist">Ban List</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="killlog"){echo ' class="active"';} ?>><a href="?page=killlog">Kill Log</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="chatlog"){echo ' class="active"';} ?>><a href="?page=chatlog">Chat Log</a></li>
                        <li<?php if(isset($_GET['page']) && $_GET['page']=="backups"){echo ' class="active"';} ?>><a href="?page=backups">DB Backups</a></li>
						<li<?php if(isset($_GET['page']) && $_GET['page']=="rcon"){echo ' class="active"';} ?>><a href="?page=rcon">RCon</a></li>
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                            </ul>
                        </li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if ( isset($_SESSION['player']) && isset($_SESSION['player']['steamid']) && isset($_SESSION['player']['name']) ){
                                $greetings = array("Hi","Hello","Welcome","Greetings","Guten Tag","Hola","Bonjour","Ciao","Salve");
                                $greeting = $greetings[array_rand($greetings)];
                        ?>
                        <li><p class="navbar-text"  style=""><?php echo $greeting . " " . $_SESSION['player']['name']; ?>!</p></li>
                        <li><a href="?page=logout">Logout</a></li>
                        <?php
                            } else {
                        ?>
                        <li><a href="?page=login" style="padding: 14px 0"><img src="http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_small.png" style="height: 20px;" /></a></li>
                        <?php } ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <!-- Navbar End -->

        <div class="container mainContent">
            <div class="content">
                <?php
                    if (isset($_SESSION['alert'])){
                        $type = $_SESSION['alert'][0];
                        $msg = $_SESSION['alert'][1];
                        unset($_SESSION['alert']);
                ?>
                <div class="alert alert-dismissible alert-<?php echo $type; ?>">
                    <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <?php echo $msg; ?>
                </div>
                <!-- End notification banner -->
                <?php } ?>

                <!-- START PAGE CONTENT -->
                <?php
                    if (!isset($_GET["page"])){
                        include("page/home.php");
                    } else {
                        switch ($_GET["page"]){
                            case "login":
                            case "logout":
                                echo "<p>The page is redirecting you... If you see this message and nothing happens, please try reloading the page or contacting the webmaster.</p>";
                                break;
                            case "itemscan":
                                include("page/itemscan/index.php");
                                break;
                            case "database":
                                include("page/database/index.php");
                                break;
                            case "banlist":
                                include("page/banlist/index.php");
                                break;
                            case "chatlog":
                                include("page/chatlog/index.php");
                                break;
                            case "killlog":
                                include("page/killlog/index.php");
                                break;
                            case "backups":
                                include("page/backups/index.php");
                                break;
							case "rcon":
                                include("page/rcon/index.php");
                                break;
                            default:
                                include("page/home.php");
                                break;
                        }
                    }
                ?>
                <!-- END PAGE CONTENT -->
				<p>Access restrictions: ItemScan (Moderator), DB Tools (Helpdesk), BanList (Helpdesk), KillLog (Helpdesk), ChatLog (Helpdesk), DB Backups (Server Admin), RCon (Admin)</p>
            </div>
        </div>

        <!-- Footer Start -->
        <div class="footer">
            <p>Website copyright &copy; 2015-2016 ozzygaming.com. All rights reserved. Design by Kieran.<br />
            This page was loaded at <?php echo date("h:iA d/m/Y"); ?> server time.</p>
        </div>
        <!-- Footer End -->
    </body>
</html>