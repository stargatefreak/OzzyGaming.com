<?php
include("../../../scripts/gamedb.php");

$email = $_POST['InputEmail1'];
$name = $_POST['adminName'];
$rank = $_POST['rank'];

$query = $gdb->prepare("INSERT INTO `arma3life`.`admins` (`adminname`, `adminlevel`, `adminbio`, `adminimage`, `adminemail`, `active`, `id`) VALUES (:name, :rank, '\"\"', 'img/noimg.jpg', :email, '', '1')");
$query->bindValue(':name',$name);
$query->bindValue(':email',$email);
$query->bindValue(':rank',$rank);
$query->execute();

echo ($rank . ' ' . $name . ' ' . $email);

?>