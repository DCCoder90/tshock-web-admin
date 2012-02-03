<?php
$senc=new sencryption;

if(isset($_GET['act'])){
	switch($_GET['act']){
		case "login":
			if(!isset($_POST['submit'])){
				die("Form not submitted!");
			}
			$user=$_POST['user'];
			$pass=$senc->shash($_POST['pass'],HASH_SALT);

			$result=$db->query("SELECT * FROM `users` WHERE `user_name`='$user'");
			$row=$result->fetch_assoc();
			$result->close();



		break;

		case "logout":
			unset($_SESSION);
			session_destroy();
			header("Location: ".HOME_URL);
		break;


	}
}


?>