<?php
    if (!isset($sec) || $sec != "para92qasozzy"){ die("Unauthorised access"); }
    if (!isset($_SESSION['player']['adminLevel']) || $_SESSION['player']['adminLevel'] < 1){
        // Team can access
        $_SESSION['alert'] = array("warning","You must be an OzzyGaming team member to access that page.");
        header("Location: ".$rootPage);
        die();
    };
?>
    <div class="col-md-2 well" style="font-size: smaller;">
        <h5>Database Tools List</h5>
        <?php
            // List of DB actions available
            $pages = array('viewJoining','viewMessages','viewRevives','viewWanted','viewRobberies','viewTransfers','viewCrafting','viewHouses');

            $pageNav = array(
                    // pageCode => minAdminLevel, pageName
                    // 1 helpdesk, 2 moderator, 3 admin, 4 server admin, 5 manager, 6 exec
                    "viewJoining"=>array(1,"View Join/Leave History"),
                    "viewMessages"=>array(1, "View Cellphone Messages"),
                    "viewRevives"=>array(1,"View Revives"),
                    "viewWanted" =>array(1,"View Wanted List Activity"),
                    "viewRobberies"=>array(2, "View Robberies"),
                    "viewTransfers"=>array(3, "View Cash Transfers"),
                    "viewCrafting"=>array(3,"View Crafting History"),
                    "viewHouses"=>array(3,"View House History"),
                );

            foreach($pageNav as $key => $page){
                if ($_SESSION['player']['adminLevel'] < $page[0]){
                    echo $page[1] . "<br />\n";
                } else {
                    if (isset($_GET['dbpage']) && $_GET['dbpage'] == $key){
                        echo '<a href="?page=database&dbpage='.$key.'" style="font-weight: bold;">'.$page[1].'</a>' . "<br />\n";
                    } else {
                        echo '<a href="?page=database&dbpage='.$key.'">'.$page[1].'</a>' . "<br />\n";
                    }
                }
            }
        ?>
    </div>
    <div class="col-md-10">
        <?php
            // Include database sub-pages
            if (!isset($_GET['dbpage']) || !in_array($_GET['dbpage'], $pages) ){
                ?>
        <h2>Database Tools</h2>
        <p>Please select a tool from the list to the left.<br />
        Tools that you cannot access are greyed out.</p>
                <?php
            } else {
                include('page/database/'.$_GET['dbpage'].'.php');
            }
        ?>
    </div>
    <div style="clear:both; margin:0; padding:0; margin-bottom: 5px;"></div>