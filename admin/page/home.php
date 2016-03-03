<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }

    if ( !isset($_SESSION['player']) || !isset($_SESSION['player']['steamid']) || !isset($_SESSION['player']['name']) ){
        echo '<h1>Welcome guest!</h1>';
        echo '<p>Please log in to use these services.</p>';
    } else{
        echo '<h1>Welcome '.$_SESSION['player']['name'].'!</h1>';
        echo '<p>You last logged in at '.date("Y-m-d H:i A",$_SESSION['loginTime']).'<br /> This session will automatically expire 24 hours after your login time.</p>';

        if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] == 0){
            echo '<p>Only OzzyGaming Team Members are permitted to use these services.</p>';
        } else {
            echo '<p>Your in-game admin level has been detected as: ' . $ranks[$_SESSION['player']['adminLevel']] . " (". $_SESSION['player']['adminLevel'] .")</p>";

?>
    <h3>News Updates</h3>
    <p>Welcome to the new admin site! Hope you enjoy!</p>
    <ul>
        <li>Ban List is working</li>
        <li>Chat Log is working, however no date, only time</li>
        <li>Kill Log is working</li>
        <li>Most DB tools for viewing main logs are working</li>
        <li>Some DB tools for viewing main logs are awaiting formatting tweaks</li>
        <li>Most pages have pagination</li>
        <li>All current features have caching (6hr frontpage stats, 30min banlist, 5min killlog, 5min db tools, 5min chat log) to reduce server load</li>
        <li></li>
        <li>Searching and ordering of tables is being looked into</li>
        <li>Item Scanner is coming soon</li>
        <li>DB backup and more DB Tools will be done after itemscanner</li>
    </ul>
<?php

            // Get some general database statistics
            include("server/generalStats.php");
            printGeneralStats($gdb);
        }
    }
?>