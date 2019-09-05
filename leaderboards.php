<html>
<head><title>Leaderboards</title></head>
<link rel="stylesheet" href="cards.css">
<body>
<a href="blackjack.php">Return to Game</a>
<?php 
require("connect.php");

$sql = "SELECT username, money FROM users WHERE money>100 ORDER BY money DESC";
$psql=$conn->prepare($sql);
$psql->execute();
$row = $psql->fetchAll();
?>
<div class="leaderboard">
<table>
<th>Winners</th>
<?php
$i = 1;
foreach($row as $a)
{
	echo "<tr><td>".$i."</td><td>".$a['username'] . "</td><td>" . $a['money'] . "</td></tr>";
	$i++;
}

?>
</table>
<?php
$sql = "SELECT username, money FROM users WHERE money<=100 ORDER BY money DESC";
$psql=$conn->prepare($sql);
$psql->execute();
$row = $psql->fetchAll();
?>
<table>
<th>Losers</th>
<?php
foreach($row as $a)
{
	echo "<tr><td>".$i."</td><td>".$a['username'] . "</td><td>" . $a['money'] . "</td></tr>";
	$i++;
}
?>
</table>
</div>
</body>
</html>