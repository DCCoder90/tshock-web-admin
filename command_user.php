<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$user=(!isset($_GET['usr']))?$_POST['usr']:$_GET['usr'];
	$group=(!isset($_GET['grp']))?null:$_GET['grp'];
	$pass=(!isset($_GET['pas']))?null:$_GET['pas'];
	$reason=(!isset($_GET['rsn']))?"Banned by web admin":$_GET['rsn'];

	$sid=(!isset($_GET['sid']))?(int)$_POST['sid']:(int)$_GET['sid'];

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['port'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "read":
			$resp=$rest->users_read($user);
			$response="User updated!<br />Username: ".$user."<br />Group: ".$resp['group']."<br />
			ID: ".$resp['id'];
		break;

		case "destroy":
			$resp=$rest->users_destroy($user);
			$response=$user." deleted!";
		break;

		case "update":
			$resp=$rest->users_update($user,$group,$pass);
			$response=$user." successfully updated!";
		break;

		case "bancreate":
			$resp=$rest->ban_create($user,null,$reason);
			$response=$user." banned!";
		break;

		case "activelist":
			$resp=$rest->users_activelist();
			$response="Active users: ".explode(",",$resp['activeusers']);
		break;


		default:
			die("Command not specified");
		break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_server.tpl');
?>