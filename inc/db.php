<?php
$database=array(
"host"=>"",
"user"=>"",
"pass"=>"",
"db"=>""
);

//////////////////////////
//DO NOT EDIT BELOW HERE!
//////////////////////////

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

if($_SESION['logged']==1){
	$smarty->assign("navigate",1);
}
?>