<?php 
//if($_SERVER['REQUEST_URI'] != "/web/home.php")header('Location:/web/home.php');
session_start();
if(isset($_SESSION['username']))
{
	unset($_SESSION['username']);
	session_destroy();
	$_SESSION = array();
	header("location: blackjack.php");
}
?>