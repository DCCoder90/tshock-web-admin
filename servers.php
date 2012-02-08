<?php
require('inc/db.php');
check_loggedin();
//Add, remove, edit
//die($_POST['action'].$_POST['act'].$_POST['submit']);

if(isset($_POST['delete'])){
	$id=(int)$_POST['serverid'];
	$query="DELETE FROM `servers` WHERE `id`=$id LIMIT 1";
	$db->query($query);
	$smarty->assign("message","Server deleted!");
	$smarty->display('main.tpl');
	die();
}

if(isset($_POST['submit'])){
	$id=(int)$_POST['sid'];
	$act=$_POST['act'];
	switch($act){
		case "add":
			$name=$_POST['name'];
			$ip=$_POST['ip'];
			$port=(int)$_POST['port'];
			$restport=(int)$_POST['restport'];
			$user=$_POST['user'];
			$pass=$_POST['pass'];

			$ltype=(int)$_POST['ltype'];
			$lname=$_POST['lname'];

			$ftpu=$_POST['ftpu'];
			$ftpp=$_POST['ftpp'];
			$ftpo=(int)$_POST['ftpo'];

			$query="INSERT INTO `servers` (`ip`,`port`,`restport`,`user_name`,`user_pass`,`name`,`log_type`,`log_name`)";

			$query=$query."VALUES('$ip','$port','$restport','$user','$pass','$name','$ltype','$lname')";

			$db->query($query);


			$smarty->assign("message","Server added!");
			$smarty->display('server/server_add.tpl');
			die();
		break;

		case "edit":

			$result=$db->query("SELECT * FROM `servers` WHERE `id`=$id");
			$row=$result->fetch_array();
			$result->close();

			$smarty->assign("svr",$row);

			$smarty->display('server/server_edit.tpl');
			die();
		break;

		case "del":
			$result=$db->query("SELECT * FROM `servers` WHERE `id`=$id");
			$row=$result->fetch_array();
			$result->close();

			$smarty->assign("svr",$row);
			$smarty->display('server/server_delete.tpl');
			die();
		break;


		default:
			die("Command not available");
		break;

	}

	clearcache();
}elseif(isset($_POST['action'])){
	$action=$_POST['action'];
	switch($action){
		case "add":
			$smarty->display('server/server_add.tpl');
			die();
		break;

		case "edit":
			$smarty->display('server/server_edit.tpl');
			die();
		break;

		case "del":
			$smarty->display('server/server_delete.tpl');
			die();
		break;

		default:
			$smarty->display('server/server_list.tpl');
			die();
		break;

	}
}else{
	$smarty->display('server/server_list.tpl');
}
?>