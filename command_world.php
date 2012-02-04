<?php
require('inc/db.php');
check_loggedin();

if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
	$autosave=(int)$_GET['as'];
	$killfriendly=(int)$_GET['kf'];
	$sid=(int)$_GET['sid'];//Server ID

	$result=$db->query("SELECT * FROM `servers` WHERE `id`=$sid LIMIT 1");
	$server=$result->fetch_assoc();
	$result->close();

	$rest->set_server($server['ip'],$server['port'],null,$server['user_name'],$server['user_pass']);

	switch($cmd){
		case "read":
			$resp=$rest->world_read();

			$resp['time']=server_time($resp['time']);

			$response="
				<table>
				  <tr>
				    <td>World Name:</td>
				    <td>".$resp['name']."</td>
				    <td>Size (x,y):</td>
				    <td>".$resp['size']."</td>
				        <td>Time:</td>
				    <td>".$resp['time']."</td>
				  </tr>
				  <tr>
				    <td>Daytime?</td>
				    <td>".$resp['daytime']."</td>
				    <td>BloodMoon?</td>
				    <td>".$resp['bloodmoon']."</td>
				    <td>Invasion Size:</td>
				    <td>".$resp['invasionsize']."</td>
				  </tr>
				</table>";
		break;

		case "meteor":
			$resp=$rest->world_meteor();
			$response="Meteor succesfully spawned!";
		break;

		case "bloodmoon":
			$resp=$rest->world_bloodmoon(true);
			$response="Bloodmoon succesfully spawned!";
		break;

		case "save":
			$resp=$rest->world_save();
			$response="World saving, server may lag.";
		break;

		case "autosave":
			if($autosave==1){
				$autosave=true;
			}else{
				$autosave=false;
			}
			$resp=$rest->world_autosave($autosave);
			$response="Autosave status set to $autosave";
		break;

		case "butcher":
			if($killfriendly==1){
				$killfriendly=true;
			}else{
				$killfriendly=false;
			}
			$resp=$rest->world_butcher($killfriendly);
			$response="NPCs butchered";
		break;

		default:
			die("Command not specified");
		break;

	}
	$smarty->assign("response",$response);
}

$smarty->display('command_world.tpl');
?>