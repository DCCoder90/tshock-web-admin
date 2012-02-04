<?php
$database=array(
"host"=>"",
"user"=>"",
"pass"=>"",
"db"=>""
);

define("HASH_SALT","1234");
//////////////////////////
//DO NOT EDIT BELOW HERE!
//////////////////////////
session_start();

$db = new mysqli($database['host'],$database['user'],$database['pass'],$database['db']);
if ($db->connect_errno)
	die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);


///////////////////////
//Include needed files
///////////////////////
require('./inc/class/rest.class.php');
require('./inc/class/senc.class.php');
require('./inc/smarty/Smarty.class.php');
$smarty = new Smarty;
$rest= new RestAPI;

///////////////////
//Get site settings
///////////////////
$result=$db->query("SELECT * FROM `settings` WHERE `id`=1");
$row=$result->fetch_assoc();
$result->close();

/////////////////////////////////
//Define Variables and constants
/////////////////////////////////
define("HOME_URL",$row['site_url']);
define("SITE_NAME",$row['site_title']);
$smarty->assign("url",$row['site_url']);
$smarty->assign("site_title",$row['site_title']);
$smarty->assign("meta_keywords",$row['meta_keywords']);
$smarty->assign("meta_desc",$row['meta_desc']);

/////////////////////////////////////////
//Get all servers and check their status
/////////////////////////////////////////

$servers=array();

$result=$db->query("SELECT * FROM `servers` ORDER BY `id` ASC LIMIT 5");
$rows=$result->fetch_all(MYSQLI_ASSOC);
foreach($rows as $row){
	$rest->set_server($row['ip'],$row['restport']);
	$server=$rest->server_status();
	if(!$status){
		$server=array("status"=>500,"playercount"=>0,"name"=>$row['name'],"port"=>$row['port']);
	}
	array_push($servers,$server);
}

$smarty->assign("servers",$servers);

$alerts=get_alerts();
$smarty->assign("alerts",$alerts);

if($_SESION['logged']==1){
	$smarty->assign("navigate",1);
}
?>