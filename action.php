<?php

if(isset($_GET['act'])){
	switch($_GET['act']){
		case "login":
		break;

		case "logout":
			unset($_SESSION);
			session_destroy();
			header("Location: ".HOME_URL);
		break;


	}
}


?>