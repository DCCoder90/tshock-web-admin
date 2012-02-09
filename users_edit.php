<?php
require('./inc/db.php');
check_loggedin();

$smarty->display('users/add_user.tpl');
?>