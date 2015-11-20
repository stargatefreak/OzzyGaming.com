<?php
    // connect to the database
    $ip = "localhost";
    $user = "root";
    $pass = '';
    $db = "kieran_ozzy";

    try {
        $dbsite = new PDO(
                        "mysql:host=".$ip.";dbname=".$db,
                        $user,
                        $pass,
                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 30)
                    );
    } catch (PDOException $ex){
        //Stop processing code and return failed JSON
        die(json_encode(array('status' => 'failed', 'message' => 'Failed to connect to database')));
    }
?>