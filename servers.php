<?php
require('inc/db.php');
check_loggedin();
//Add, remove, edit

if(isset($_POST['action'])){
	$action=$_POST['action'];
	switch($action){
		case "add":
			$smarty->display('server/server_add.tpl');
		break;

		case "edit":
			$smarty->display('server/server_edit.tpl');
		break;

		case "del":
			$smarty->display('server/server_delete.tpl');
		break;

		default:
			$smarty->display('server/server_list.tpl');
		break;

	}
}else{
	$smarty->display('server/server_list.tpl');
}
?>