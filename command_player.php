<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$user=(!isset($_GET['usr']))?$_POST['usr']:$_GET['usr'];
	$reason=(!isset($_GET['rsn']))?null:$_GET['rsn'];

	$sid=(!isset($_GET['sid']))?(int)$_POST['sid']:(int)$_GET['sid'];

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['restport'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "read":
			$parse=new parser;
			$resp=$rest->player_read($user);

			$inventory=$parse->parse_inventory($resp['inventory']);
			$pos=explode(",",$resp['position']);
			$response="Nickname: ".$resp['nickname']."<br />
						Username: ".$resp['username']."<br />
						IP: ".$resp['ip']."<br />
						Group: ".$resp['group']."<br />
						Position: X-".$pos[0]."  Y-".$pos[1]."<br />
						Inventory: <br />";
			foreach($inventory as $item){
				$response=$response.$item['name']."-".$item['amount']."<br />";
			}
			$response=$response."Buffs:<br />".$resp['buffs'];
		break;

		case "kick":
			$resp=$rest->player_kick($user,$reason);
			$response=$user." kicked!";
		break;

		case "ban":
			$resp=$rest->player_ban($user,$reason);
			$response=$user." banned!";
		break;

		case "kill":
			$resp=$rest->player_kill($user);
			$response=$user." was killed!";
		break;

		case "mute":
			$resp=$rest->player_mute($user,$reason);
			$response=$user." muted!";
		break;

		case "unmute":
			$resp=$rest->player_unmute($user,$reason);
			$response=$user." unmuted!";
		break;


		default:
			die("Command not specified");
		break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_player.tpl');
?>