<?php
//Creates the server status image
$name=urldecode($_GET['name']);
$playercount=(int)$_GET['playercount'];
$port=(int)$_GET['port'];
$status=(int)$_GET['status'];

$img=ImageCreateFromJPEG(HOME_URL."/images/status.jpg");
$color = imagecolorallocate($img, 0, 0, 0);


if($status==200){
	$statustxt="Up";
	$status_color=imagecolorallocate($img,0,255,0);
}elseif($status==500){
	$statustxt="Down";
	$status_color=imagecolorallocate($img,255,0,0);
}else{
	$statustxt="Error";
	$status_color=imagecolorallocate($img,0,255,255);
}

imagestring( $img,5,20,22,"Map Name: ".$name,$color); //name
imagestring( $img,5,20,42,"Port: ".$port,$color); //port
imagestring( $img,5,20,52,"Status: ".$statustxt,$status_color); //status

if($status!=500){
	imagestring( $img,5,20,32,"Players: ".$playercount,$color); //count
}


header('Content-type: image/jpeg');
imagejpeg($img);
?>