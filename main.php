<?php
require('inc/db.php');
check_loggedin();

$smarty->display('main.tpl');
?>