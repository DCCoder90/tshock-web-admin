<?php

$database=array(
"host"=>"",
"user"=>"",
"pass"=>"",
"db"=>""
);

$db = new mysqli($database['host'],$database['user'],$database['pass'],$database['db']);
if ($db->connect_errno)
	die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);


require('./inc/class/rest.class.php');
require('./inc/smarty/Smarty.class.php');
$smarty = new Smarty;
?>