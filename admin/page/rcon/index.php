<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); };
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 3){
        // Admin can access
        $_SESSION['alert'] = array("warning","You must be at least a Admin to access that page.");
        header("Location: ".$rootPage);
        die();
    };
	regenBanList();
	
	function regenBanList(){
		$config2 = file_get_contents('D:\ozzygamingservices\armatest\battleye\beserver.cfg');
		preg_match_all("/R[A-z]\w+\s([\S]*)/i", $config2, $password2);
		
		echo '<h1>ArmA RCon Passwords</h1>';
		
		foreach ($password2[1] as $pass) {
			echo "<b>IP: life.ozzygaming.com<br>";
			echo "Port: 2302<br>";
			echo "Username: ", $_SESSION["player"]["igName"], "<br>";
			echo "Password: ", $pass, '<br>';
		};
	};
die();
?>