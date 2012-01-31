<?php

/**
 * sencryption
 *
 * @package Sencryption Class
 * @author Ernest
 * @copyright Copyright (c) 2011
 * @version 0.1
 * @access public
 */
class sencryption{
	/**
	 * Encryption/Decryption Settings
	 *
	 */
	private $key;
	private $key_size;
	private $ciphers;
	private $set_cipher;
	private $sen_handle;
	private $lib_dir;
	private $iv_size;
	private $iv;
	/**
	 * Hash Settings
	 *
	 */
  	private $sha_handle;
	private $tohex;
	private $algo;
	/**
	 * Other Settings
	 *
	 */
	private $chars;
	private $fb;

	/**
	 * encryption::__construct()
	 * $funct 1=hash 2=encryption 3=both
	 */
	public function __construct($key="",$funct=3,$tohex=TRUE){
		$this->key=$key;
		$this->fb="";
		$this->set_cipher="";
		if($funct==1||$funct==3){
			$this->tohex=$tohex;
			$this->algo=hash_algos();
		}
		$this->chars=array("a","b","c","d","e","f","g","h","i","j","k",
		"l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
		"!","@","#","$","%","^","&","*","(",")","-","_","+","=","<",
		",",">",".","?","/",";",":","'","\"","[","{","]","}","\\","|",
		"~","`"); //Total of 54 characters
	}

	/**
	 * encryption::sencrypt()
	 * * Function encrypts a data set *
	 * @return string
	 */
	public function sencrypt($data){
		$this->sen_init($data);
		$this->key = substr($this->shash($this->key), 0, $this->key_size);
		$this->iv=mcrypt_create_iv($this->iv_size, MCRYPT_DEV_RANDOM);
		mcrypt_generic_init($this->sen_handle, $this->key, $this->iv);
		$sen = mcrypt_generic($this->sen_handle, $data);
		$return=$this->fb.$this->iv.$sen;
		$this->sen_dest();
		return $return;
	}

	/**
	 * encryption::sdecrypt()
	 *  * Function decrypts an encrypted data set *
	 * @return string
	 */
	public function sdecrypt($data){
		$this->sen_init($data);
		$this->iv=substr($data,1,$this->iv_size);
		$ivp1=$this->iv_size+1;
		$data=substr_replace($data,"",0,$ivp1);
		mcrypt_generic_init($this->sen_handle, $this->key, $this->iv);
		$return = mdecrypt_generic($this->sen_handle, $data);

		return $return;
	}

	/**
	 * sencryption::load_ciphers()
	 * * Loads list of ciphers from the library or from a txt file *
	 * @return NULL
	 */
	public function load_ciphers($loc=""){
		if(substr($loc,-4,4)==".txt"){
			if($fh=fopen($loc,r)){
				while($line=fgets($fh)){
					$ciphers[]=$line;
				}
				fclose($fh);
				$this->ciphers=$ciphers;
			}else{
				die("Error reading ciphers!");
			}
		}else{
			if($loc==""||$loc==NULL){
				$loc=ini_get("mcrypt.algorithms_dir");
			}
			$this->lib_dir=$loc;
			$this->ciphers=mcrypt_list_algorithms($loc);
		}
		return NULL;
	}

	/**
	 * encryption::shash()
	 * * Function returns a secure hash of a data set *
	 * @return string
	 */
	public function shash($data, $salt = null){
		if($salt == null && $this->fb !== ""){
			$fb = $this->fb;
		}elseif($salt == null && $this->fb == ""){
			$fb = "a";
		}

		if($salt!==NULL&&$salt!==""){
			$fb=substr($salt,0,1);
		}
		$algo_num = count($this->algo);
		$numeric = array_search($fb, $this->chars);
		while($numeric > $algo_num){
			$numeric = $numeric - $algo_num;
		}
		if($numeric > 0){
			$numeric = $numeric - 1;
		}
		$algo = $this->algo[$numeric];
		if($this->tohex == true){
			$data = $this->str2hex($data);
		}

		if($salt!==NULL&&$salt!==""){
			$hash=hash($algo.$salt,$data,false);
		}else{
			$hash = hash($algo, $data, false);
		}
		return $hash;
	}

	/**
	 * sencryption::set_ciph()
	 * * Sets the correct cipher *
	 * @return NULL
	 */
	private function set_ciph($data){
		$ciph_num=count($this->ciphers);
		$this->fb=substr($data,0,1);
		$numeric=array_search($this->fb,$this->chars);
		while($numeric>$ciph_num){
			$numeric=$numeric-$ciph_num;
		}
		if($numeric>0){
			$numeric=$numeric-1;
		}
		$this->set_cipher=$this->ciphers[$numeric];
		return NULL;
	}

	/**
	 * sencryption::sen_init()
	 * * Initializes the encryption methods *
	 * @return null
	 */
	private function sen_init($data){
		$this->set_ciph($data);

		$this->sen_handle=mcrypt_module_open($this->set_cipher, $this->lib_dir, 'ofb', '');
		$this->check_cipher();
		$this->iv_size=mcrypt_enc_get_iv_size($this->sen_handle);
		$this->key_size= mcrypt_enc_get_key_size($this->sen_handle);
		return NULL;
	}

	/**
	 * sencryption::sen_dest()
	 * * Destroys current session *
	 * @return NULL
	 */
	private function sen_dest(){
		mcrypt_generic_deinit($this->sen_handle);
		mcrypt_module_close($this->sen_handle);
		return NULL;
	}

	/**
	 * encryption::check_cipher()
	 *  * Function checks cipher to ensure that we can use it *
	 * @return true
	 */
	private function check_cipher(){
		if(!mcrypt_module_self_test($this->set_cipher,$this->lib_dir)){
			die("Cipher check failed!");
		}
		return TRUE;
	}

	/**
	 * encryption::str2hex()
	 * * Function returns the hexadecimal value of a string *
	 * @return hex
	 */
	private function str2hex($string=""){
		$hex='';
		for ($i=0; $i < strlen($string); $i++){
				$hex .= dechex(ord($string[$i]));
		}
		return $hex;
	}

}

?>