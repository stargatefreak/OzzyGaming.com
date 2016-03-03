<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 4){
        // Admins can access
        $_SESSION['alert'] = array("warning","You must be at least a Server Admin to access that page.");
        header("Location: ".$rootPage);
        die();
    };
?>