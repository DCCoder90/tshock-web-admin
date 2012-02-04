<?php
require("inc/db.php");
$senc=new sencryption;

if(isset($_GET['act'])){
	switch($_GET['act']){
		case "login":
			if(!isset($_POST['submit'])){
				die("Form not submitted!");
			}
			$user=$_POST['user'];
			$pass=$senc->shash($_POST['pass']);

			$result=$db->query("SELECT * FROM `users` WHERE `user_name`='$user'");
			$row=$result->fetch_assoc();
			$result->close();

			if($user==$row['user_name']&&$pass==$row['user_pass']){
				$_SESSION['logged']=1;
				$_SESSION['id']=$row['id'];
				$_SESSION['user']=$user;
				$_SESSION['email']=$row['user_email'];
				header("Location: ".HOME_URL."/main.php");
				die(HOME_URL);
			}else{
				header("Location: ".HOME_URL."/index.php?loginerr=1");
			}

		break;

		case "logout":
			unset($_SESSION);
			session_destroy();
			header("Location: ".HOME_URL);
		break;


	}
}


?>