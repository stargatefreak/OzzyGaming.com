<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Anyone can access
        $_SESSION['alert'] = array("warning","You must be at least Helpdesk to access that page.");
        header("Location: ".$rootPage);
        die();
    };

    echo "<p>This is currently not available until the actual logging of the chat is fixed.</p>";
?>