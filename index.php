<?php
session_start();
require('inc/db.php');


if(isset($_SESSION['logged'])){
	$smarty->display('index.tpl');
}else{
	$smarty->display('login.tpl');
}
?>
