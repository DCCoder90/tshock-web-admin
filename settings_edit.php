<?php
require('inc/db.php');
check_loggedin();

$smarty->display('settings_edit.tpl');
?>