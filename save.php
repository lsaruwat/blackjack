<?php
require("connect.php");
$sql = "SELECT money FROM users WHERE username = :username";
	$psql=$conn->prepare($sql);
	$psql->execute(array(":username"=>$_POST['username']));
	$row = $psql->fetch();
$money = $_POST['money'] - $row['money'];
if($money > 150) $money = 0;
else $money = $_POST['money'];
$sql = "UPDATE users SET money = :money WHERE username = :username";
	$psql=$conn->prepare($sql);
	$psql->execute(array(":money"=>$money, ":username"=>$_POST['username']));
	echo $money . " " . $_POST['username'];
?>