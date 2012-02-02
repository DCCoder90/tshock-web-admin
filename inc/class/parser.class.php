<?php
class parser{

	//Returns and array named $log
	//type,flag,user,action,info,misc
	public function parse_log($data){
		$lines=explode("\n",$data);
		foreach($lines as $line){
			preg_match("/^([0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/",$line,$datetime);
			$meta=explode(":",substr($line,22));
			$log['type']=$meta[0]; //Ex. TShock, StatTracker, Utils, etc...
			$log['flag']=$meta[1]; //Ex. INFO

			if(count($meta)>2){
				if(strpos($meta[2],"executed")>0){
					$log['user']=str_replace(" executed","",$meta[2]);
					$log['action']=$meta[3];
				}else{

					if(count($meta)>4){
						for($i=4;$i<=count($meta);$i++){
							$meta[4].=$meta[$i];
						}
					}else{
						$meta[4]="";
					}
					$log['user']=$meta[2];
					$log['action']="";
					$log['info']=$meta[3];
					$log['misc']=$meta[4];
				}
			}else{
				$log['action']=$meta[2];
			}
			//preg_match("/")
		}
		return $log;
	}

	//Parses a player's inventory which is obtained through
	//the Rest API
	public function parse_inventory($data){
		$inventory=explode(",",$data);
		$inv=array();
		foreach($inventory as $items){
			$item=explode(":",$items);
			if($item[0]=""&&$item[1]==0){
				$temp['name']="Empty Slot";
				$temp['amount']=0;
			}else{
				$temp['name']=$item[0];
				$temp['amount']=$item[1];
			}
			array_push($inv,$temp);
		}
		return $inv;
	}
}
?>