<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$msg=(!isset($_GET['msg']))?(int)$_POST['msg']:(int)$_GET['msg'];;
	$rawcmd=$_GET['rawcmd'];

	$sid=(!isset($_GET['sid']))?(int)$_POST['sid']:(int)$_GET['sid'];

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['port'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "cast":
			$resp=$rest->server_broadcast($msg);
			$response="Broadcast Succesfull.";
		break;

		case "status":
			$resp=$rest->server_status();

			$players=explode(",",$resp['players']);

			foreach($players as $player)
			{
				$p[]="<a href=\"".HOME_URL."\"/command_players.php?cmd=read&plr=".$player."&sid=".$sid."\">".$player."</a>";
			}
			$response="World Name: ".$resp['name']."<br />
				Port: ".$resp['port']."<br />
				Player Count: ".$resp['playercount']."<br />
				Players: ";

			foreach($p as $p){
				$response=$response.$p.",";
			}

			$response=$response."<br />";
		break;

		case "off":
			$resp=$rest->server_off(true,false);
			$response="Server shutting down.  Saving world...";
		break;

		case "rawcmd":
			$resp=$rest->server_rawcmd($rawcmd);
			$response=$resp['response'];
		break;

		default:
			die("Command not specified");
		break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_server.tpl');
?>