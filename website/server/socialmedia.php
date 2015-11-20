<?php
	if (!isset($sec) || $sec !== '123cust') { die(); }
	if (!isset($dbsite)){ require("../server/dbsite.php"); }

	$var = array(); //replace with call to database

	foreach ($var as $site=>$link){
		if (!strpos($link, "://")){
			$link = "http://".$link;
		}

		switch ($site){
			case "facebook":
				echo '<a href="'.$link.'"><img src="images/socialmedia/facebook.png" alt="Facebook" title="Facebook" /></a>';
				break;
			case "googleplus":
				echo '<a href="'.$link.'"><img src="images/socialmedia/google-plus.png" alt="Google Plus" title="Google+" /></a>';
				break;
			case "twitter":
				echo '<a href="'.$link.'"><img src="images/socialmedia/twitter.png" alt="Twitter" title="Twitter" /></a>';
				break;
			case "steam":
				echo '<a href="'.$link.'"><img src="images/socialmedia/steam.png" alt="Steam" title="Steam" /></a>';
				break;
			case "irc":
				echo '<a href="'.$link.'"><img src="images/socialmedia/irc.png" alt="IRC Chat" title="IRC Chat" /></a>';
				break;
			case "twitch":
				echo '<a href="'.$link.'"><img src="images/socialmedia/twitch.png" alt="Twitch" title="Twitch" /></a>';
				break;
			case "youtube":
				echo '<a href="'.$link.'"><img src="images/socialmedia/youtube.png" alt="YouTube" title="YouTube" /></a>';
				break;
			case "vimeo":
				echo '<a href="'.$link.'"><img src="images/socialmedia/vimeo.png" alt="Vimeo" title="Vimeo" /></a>';
				break;
			case "instagram":
				echo '<a href="'.$link.'"><img src="images/socialmedia/instagram.png" alt="Instagram" title="Instagram" /></a>';
				break;
			case "tumblr":
				echo '<a href="'.$link.'"><img src="images/socialmedia/tumblr.png" alt="Tumblr" title="Tumblr" /></a>';
				break;
		}
	}
?>