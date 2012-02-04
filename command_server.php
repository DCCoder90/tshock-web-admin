<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$msg=$_POST['msg'];

	//Hmm...may have these backwards...not sure, and to lazy to check now
	$sid=(!isset($_GET['sid']))?(int)$_GET['sid']:$_POST['sid'];//Server ID

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['port'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "cast":
			$resp=$rest->server_broadcast($msg);
			$response="Broadcast Succesfull.";
			break;

		default:
			die("Command not specified");
			break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_server.tpl');
?>