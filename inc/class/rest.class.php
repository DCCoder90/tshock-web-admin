<?php
/**
 * RestAPI
 *
 * @package RestAPI Class (Tshock-web-admin)
 * @author Ernest
 * @copyright Copyright (c) 2012
 * @version 0.1
 * @access public
 */

//Noon=27000.0
//Midnight=16200.0
//Day=150.0
//Night=0.0

class RestAPI{

	protected $ip;  //Server IP
	protected $port;//RestAPI Port
	protected $token; //Rest API token

	private $user; //Admin username
	private $pass; //Admin password

	public function set_server($ip,$port,$token=null,$user=null,$pass=null){
		$this->ip=$ip;
		$this->port=(int)$port;
		$this->token=$token;
		$this->user=$user;
		$this->pass=$pass;
	}

	private function get_json($endpoint=null,$gettoken=true){
		if($gettoken){
			$token=$this->get_token();
			$endpoint=$endpoint."&token=".$token;
		}elseif($gettoken=="set"){
			$token=$this->get_token();
			$endpoint=$endpoint."?token=".$token;
		}
		$contents=file_get_contents("http://".$this->ip.":".$this->port.$endpoint);
		$json=json_decode($contents,true);
		return $json;
	}

	//////////////////////////
	//Misc Endpoints
	/////////////////////////

	private function get_token(){
		if($this->token==""||$this->token==null){
			$json=$this->get_json("/token/create/".$this->user."/".$this->pass);
			if($json['status']==200){
				$this->token=$json['token'];
				return $this->token;
			}else{
				die("Failed to get token!");
			}
		}else{
			return $this->token;
		}
	}

	public function check_token($token=null){
		if($token==""||$token==null){
			return false;
		}
		$json=$this->get_json("/tokentest?token=".$token);
		if($json['status']==200){
			return true;
		}elseif($json['status']==400){
			return false;
		}
	}

	public function player_lists(){
		$json=$this->get_json("/lists/players","set");
		return $json;
	}

	/////////////////////////
	//Server Endpoints
	/////////////////////////
	public function server_status(){
		$json=$this->get_json("/status",false);
		if($json['status']==200){
			return $json;
		}else{
			return false;
		}
	}

	public function server_broadcast($msg=null){
		$json=$this->get_json("/v2/server/broadcast?msg=".$msg);
		return $json;
	}

	public function server_off($confirm=true,$nosave=false){
		$json=$this->get_json("/v2/server/off?confirm=".$confirm."&nosave=".$nosave);
		return $json;
	}

	public function server_rawcmd($cmd=null){
		$json=$this->get_json("/v2/server/rawcmd?cmd=".$cmd);
		return $json;
	}

	/////////////////////////
	//Player Endpoints
	/////////////////////////

	public function player_read($player=null){
		$json=$this->get_json("/v2/players/read?player=".$player);
		return $json;
	}

	public function player_kick($player=null,$reason=null){
		$endpoint="/v2/players/kick?player=".$player;

		if(!is_null($reason)){
			$endpoint=$endpoint."&reason=".$reason;
		}
		$json=$this->get_json($endpoint);
		return $json;
	}

	public function player_ban($player=null,$reason=null){
		$endpoint="/v2/players/ban?player=".$player;

		if(!is_null($reason)){
			$endpoint=$endpoint."&reason=".$reason;
		}
		$json=$this->get_json($endpoint);
		return $json;
	}

	public function player_kill($player=null){
		$json=$this->get_json("/v2/players/kill?player=".$player);
		return $json;
	}

	public function player_mute($player=null,$reason=null){
		$endpoint="/v2/players/mute?player=".$player;

		if(!is_null($reason)){
			$endpoint=$endpoint."&reason=".$reason;
		}
		$json=$this->get_json($endpoint);
		return $json;
	}

	public function player_unmute($player=null,$reason=null){
		$endpoint="/v2/players/unmute?player=".$player;

		if(!is_null($reason)){
			$endpoint=$endpoint."&reason=".$reason;
		}
		$json=$this->get_json($endpoint);
		return $json;
	}

	/////////////////////////
	//World Endpoints
	/////////////////////////

	public function world_read(){
		$json=$this->get_json("/world/read","set");
		return $json;
	}

	public function world_meteor(){
		$json=$this->get_json("/world/meteor","set");
		return $json;
	}

	public function world_bloodmoon($moon=false){
		$json=$this->get_json("/world/bloodmoon/".$moon,"set");
		return $json;
	}

	public function world_save(){
		$json=$this->get_json("/v2/world/save","set");
		return $json;
	}

	public function world_autosave($save=true){
		$json=$this->get_json("/v2/world/autosave/state/".$save,"set");
		return $json;
	}

	public function world_butcher($killfriendly=false){
		$json=$this->get_json("/v2/world/butcher?killfriendly=".$killfriendly);
		return $json;
	}

	/////////////////////////
	//User Endpoints
	/////////////////////////

	public function users_activelist(){
		$json=$this->get_json("/users/activelist","set");
		return $json;
	}

	public function users_read($user){
		$json=$this->get_json("/v2/users/read?user=".$user);
		return $json;
	}

	public function users_destroy($user){
		$json=$this->get_json("/v2/users/destroy?user=".$user);
		return $json;
	}

	public function users_update($user,$group=null,$pass=null){
		$uri="/v2/users/update?user=".$user;
		if($group==null||$group=="")
			$uri=$uri."&group=".$group;
		if($pass==null||$pass=="")
			$uri=$uri."&password=".$pass;
		$json=$this->get_json($uri);
		return $json;
	}

	public function ban_create($user=null,$ip=null,$reason="Banned by webadmin."){
		if($user==null&&$ip==null)
			return false;
		$uri="/bans/create?";
		if($user!=null)
			$uri=$uri."user=".$user;
		if($user==null&&$ip!=null){
			$uri=$uri."ip=".$ip;
		}elseif($ip!=null){
			$uri=$uri."&ip=".$ip;
		}

		$uri=$uri."reason=".$reason;
		$json=$this->get_json($uri);
		return $json;
	}
}

?>