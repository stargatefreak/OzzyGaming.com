<?php
// Connect to DB
$ip = "125.63.48.152";
$port = "3306";
$db = "arma3life";
$user="website";
$pass='fh}rQ:wq!WBq9%cukivZ99s^|p|6P{"}27mi/FRC!;"ia';

try {
    $wdb = new PDO(
                    "mysql:host=".$ip.";port=".$port.";dbname=".$db,
                    $user,
                    $pass,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 30)
                );
} catch (PDOException $ex){
    //Stop processing code and return failed JSON
    die(json_encode(array('status' => 'failed', 'message' => 'Failed to connect to database')));
}
?>