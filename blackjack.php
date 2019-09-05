<?php
session_start();
require("connect.php");
?>

<html>
<head>
<title>Cards</title>
<link rel="stylesheet" type="text/css" href="cards.css">
<script type="text/javascript" src="classes.js"></script>
</head>
<body>
<div class="login-area">
<?php
if(isset($_SESSION['username']))
{
	$sql = "SELECT money FROM users WHERE username = :username";
	$psql=$conn->prepare($sql);
	$psql->execute(array(":username"=>$_SESSION['username']));
	$row= $psql->fetch();
	$_SESSION['money'] = $row['money'];
	echo "<input id='sessionMoney'type='hidden' value='".$_SESSION['money']."'>";
	echo "<input id='sessionUsername'type='hidden' value='".$_SESSION['username']."'>";
	echo "Welcome ".$_SESSION['username']." <a href='logout.php'>Logout</a>";
}
else
{
?>
<div id="login-area">
<form id="login" class ="right" action="login.php" method="POST">
Username:<input class='text' type="text" name="username">
Password:<input class='text' type="password" name="password">
<input type="submit" value="Login">
<a  href='registerform.php'>Register</a>
</form>
</div>
<?php
}
?>
<a href="leaderboards.php">Leaderboards</a>
</div>
<div id="game-status"></div>
<div id="money"></div>
	<div class="bet">
	<div id="betValue"></div>
		<select id="bet">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="50">50</option>
		</select>
	</div>
	<div class="card-table">
	<div class="user-area">
	<div class="score-parent">
		<p>Score</p>
			<div id="user-score"class="score">
			</div>
		</div>
	<div id="user-hand" class="hand">
	<h2>User Hand</h2>
	</div>
	</div>
	<div class="dealer-area">
	<div class="score-parent">
		<p>Score</p>
			<div id="dealer-score"class="score">
			</div>
		</div>
	<div id="dealer-hand" class="hand">
	<h2>Dealer Hand</h2>
	</div>
	</div>
	</div>
	<div id="user-buttons" class="controls">
	<div class="button"><input type="button" id="doubleDown" value="Double"></div>
	<div class="button"><input type="button" id="hit" value="Hit"></div>
	<div class="button"><input type="button" id="stand" value="Stand"></div>
	<div class="button"><input type="button" id="replay" value="Deal"></div>	
	</div>
</body>
</html