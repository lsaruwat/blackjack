<?php
require_once "connect.php";
	function generateRandomString($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	$salt = generateRandomString(16);
	$username = $_POST['username'];
	$password = sha1($_POST["password"].$salt);
	$password2 = sha1($_POST["password2"].$salt);
	if(strlen(trim($username)) < 5){
		echo "<a href='registerform.php'>username is too short or contains spaces</a>";
		exit;
	}
		$check="SELECT * FROM users WHERE username = :username";
		$psql=$conn->prepare($check);// check for sql injection flaws
		$psql->execute(array(":username"=>$username));// run the query on database replacing flaws with escaped variables
		$exists = false;
		while($row = $psql->fetch())
		{
			if($username == $row['username'])
			{
				echo "username already exists";
				$exists  = true;
				break;
			}
		}

if($exists == false)
 {
	if($password==$password2)
	{

	 $sql="INSERT INTO users (username, password, salt)
		VALUES (:username,:password,:salt)";
		$psql=$conn->prepare($sql);
		$psql->execute(array(":username"=>$username, ":password"=>$password, ":salt"=>$salt));
	
	echo "<h1>Registration Successful</h1>";
	echo "<script type='text/javascript'>
	setTimeout(function start(){window.location = 'blackjack.php'},1000);
window.addEventListener('onload', start, false);
</script>";
	}
else echo"</br><a href='registerform.php'>passwords didn't match</a></br>";
 } 
?>