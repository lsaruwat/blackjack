<?php
session_start();
require("connect.php");
$sesuser = $_POST['username'];
$sql = "SELECT salt FROM users WHERE username = :username";
$psql=$conn->prepare($sql);
$psql->execute(array(":username"=>$sesuser));
$row= $psql->fetch();
$salt = $row['salt'];
$sespass = sha1($_POST['password'].$salt);
$sql="SELECT * FROM users WHERE username = :username AND password = :password";
$psql=$conn->prepare($sql);
$psql->execute(array(":username"=>$sesuser, ":password"=>$sespass));
$row= $psql->fetch();

	if($row!=NULL)
	{
		$_SESSION['role'] = $row['roles'];
		$_SESSION['username'] = $row['username'];
		$id = $row['PID'];
		$_SESSION['id']=$id;
		$email = $row['email'];
		$_SESSION['email']=$email;
		header("location: blackjack.php");
	}

	else 
		{
			echo"<h1>The username or password doesn't exist! Please try again</h1>";
			require("logout2.php");
		}
?>
		</body>
		</html>