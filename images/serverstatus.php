<?php
chdir("../");
define("IMAGE",true);
include("./inc/db.php");

//Creates the server status image
$name=urldecode($_GET['name']);
$playercount=(int)$_GET['playercount'];
$port=(int)$_GET['port'];
$status=(int)$_GET['status'];

if($status==200){
	$image="Online.jpg";
}else{
	$image="Offline.jpg";
}

$img=ImageCreateFromJPEG(HOME_URL."/images/".$image);

//$img=ImageCreateFromJPEG("./images/".$image);

if($status==200){
	$statustxt="Up";
	$color = imagecolorallocate($img, 0, 0, 0);
	$status_color=imagecolorallocate($img,255,255,0);
}elseif($status==500){
	$statustxt="Down";
	$color = imagecolorallocate($img, 255, 0, 0);
	$status_color=imagecolorallocate($img,255,0,0);
}else{
	$statustxt="Error";
	$status_color=imagecolorallocate($img,0,255,255);
}

imagestring( $img,5,20,2,"Map Name: ".$name,$color); //name
imagestring( $img,5,20,12,"Port: ".$port,$color); //port
imagestring( $img,5,20,22,"Status: ".$statustxt,$status_color); //status

if($status!=500){
	imagestring( $img,5,20,32,"Players: ".$playercount,$color); //count
}


header('Content-type: image/jpeg');
imagejpeg($img);
?>