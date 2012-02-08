<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$msg=(!isset($_GET['msg']))?$_POST['msg']:$_GET['msg'];;
	$rawcmd=(isset($_GET['rawcmd']))?$_GET['rawcmd']:"";

	$sid=(!isset($_GET['sid']))?(int)$_POST['sid']:(int)$_GET['sid'];

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['restport'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "cast":
			$resp=$rest->server_broadcast($msg);
			$response="Broadcast Succesfull.";
		break;

		case "status":
			$resp=$rest->server_status();

			$players=explode(",",$resp['players']);

			$i=0;
			foreach($players as $player)
			{
				if($i!=0){
					$player=substr($player,1);
				}
				$p[]="<a href=\"".HOME_URL."/command_player.php?cmd=read&usr=".$player."&sid=".$sid."\">".$player."</a>";

				$i++;
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
			$resp=$rest->server_rawcmd(urlencode($rawcmd));
			if(isset($resp['response'])){
				$response=$resp['response'];
			}else{
				if($resp['status']==200){
					$response="Command succesful";
				}else{
					$response="Command failed";
				}
			}
		break;

		default:
			die("Command not specified");
		break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_server.tpl');
?>