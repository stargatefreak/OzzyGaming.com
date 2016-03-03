<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 2){
        // Moderators can access
        $_SESSION['alert'] = array("warning","You must be at least a Moderator to access that page.");
        header("Location: ".$rootPage);
        die();
    };
?>