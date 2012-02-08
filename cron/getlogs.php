<?php
/*
 * This file is meant to be run via a cron tab or by some
 * other automated process.
 * Note: This process could take a while depending on number of
 * servers and system resources.
*/
set_time_limit(0);
chdir('../');

include('./inc/db.php');
include('./inc/class/ftp.class.php');
$ftp=new FTP;
$parser=new parser;


$result=$db->query("SELECT * FROM `servers`");
$rows=$result->fetch_all(MYSQLI_ASSOC);
$result->close();

$local=array();
$remote=array();
foreach($rows as $server){
	if($server['log_type']==0){
		array_push($local,$server);
	}elseif($server['log_type']==1){
		array_push($remote,$server);
	}
}

//Grab and parse local logs
foreach($local as $server){
	$result=$db->query("SELECT * FROM `log_local` WHERE `server_id`=".$server['id']);
	$row=$result->fetch_assoc();
	$result->close();

	if($server['log_name']=="log.txt"){
		$logname="log.txt";
	}else{
		$dh = opendir($row['path']);
		$files=array();
		while (false !== ($entry = readdir($handle))) {
			$entry=str_replace(".log","",$entry);
			array_push($files,$entry);
		}
		closedir($dh);
		$file=max($files);
		$logname=$file.".log";
	}

	$fh=fopen($row['path']."log.txt","r");
	$data=fread($fh,filesize($row['path'].$logname));
	$data=$parser->parse_log($data);
	fclose($fh);

	$query="INSERT INTO `server_logs` (`server_id`,`log_date`,`log_type`,`log_flag`,`log_user`,`log_action
			`,`log_info`,`log_misc`,`priority`,`date`)";
	$query=$query."VALUES('".$server['id']."','".$data['date']."','".$data['type']."','".$data['flag']
					."','".$data['user']."','".$data['action']."','".$data['info']."','".$data['misc']
					."','"."2"."','".time();
	$db->query($query);
}

//grab and parse remote logs
foreach($remote as $server){
	$result=$db->query("SELECT * FROM `log_ftp` WHERE `server_id`=".$server['id']);
	$row=$result->fetch_assoc();
	$result->close();

	$ftp->connect($server['ip'],$row['port']);
	$ftp->login($row['user_name'],$row['user_pass']);
	if($ftp->pwd()!="tshock"){
		$ftp->chdir("tshock");
	}

	if($server['log_name']=="log.txt"){
		$logname="log.txt";
	}else{
		$filelist=$ftp->nlist();
		$files=array();

		foreach($filelist as $file){
			$file=str_replace(".log","",$file);
			array_push($files,$file);
		}

		$file=max($files);
		$logname=$file.".log";
	}

	$fh=fopen("./temp/temp/log.txt","w+");
	$ftp->fget($fh,$logname);
	fclose($fh);
	$ftp->disconnect();

	$fh=fopen("./temp/temp/log.txt","r");
	$data=fread($fh,filesize("./temp/temp/log.txt"));
	$data=$parser->parse_log($data);
	fclose($fh);

	$query="INSERT INTO `server_logs` (`server_id`,`log_date`,`log_type`,`log_flag`,`log_user`,`log_action
			`,`log_info`,`log_misc`,`priority`,`date`)";
	$query=$query."VALUES('".$server['id']."','".$data['date']."','".$data['type']."','".$data['flag']
				."','".$data['user']."','".$data['action']."','".$data['info']."','".$data['misc']
				."','"."2"."','".time();
	$db->query($query);
}

echo "Get logs completed.";
?>