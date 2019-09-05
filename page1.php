<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("classes.php");

$page1 = new Page("page 1");
$page1->build();

$deck1 = new Deck;
$deck1->shuffle();
$deck1->deal();


?>