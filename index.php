<?php
require('inc/db.php');
$error="";

if(isset($_GET['loginerr'])&&$_GET['loginerr']==1){
	$error="Username/Password Incorrect";
}

$smarty->assign("error",$error);
$smarty->display('index.tpl');
?>