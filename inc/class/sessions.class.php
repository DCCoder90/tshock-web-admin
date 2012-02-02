<?php
/**
 * session
 *
 * @package
 * @author Darkvengance
 * @copyright Copyright (c) 2011
 * @version $Id$
 * @access public
 */
class session {
	// session-lifetime
	var $lifeTime;
	// mysql-handle
	var $db;

	function __construct($db){
		$this->db=$db;
	}

	/**
	 * Opens a session
	 *
	 * @param mixed $savePath
	 * @param mixed $sessName
	 * @return bool
	 */
	function open($savePath, $sessName) {
		$this->lifeTime = get_cfg_var("session.gc_maxlifetime");
		return true;
	}

	/**
	 * Closes a session
	 *
	 * @return bool
	 */
	function close() {
		$this->gc(ini_get('session.gc_maxlifetime'));
		return true;
	}

	/**
	 * Reads data from a session
	 *
	 * @param mixed $sessID
	 * @return mixed
	 */
	function read($sessID) {
		$res = $this->db->query("SELECT `session_data` AS d FROM `site_sessions`
                            WHERE `session_id` = '$sessID'
                            AND `session_expires` > ".time());
		if($row = $res->fetch_assoc()){
			return $row['d'];
		}else{
			return "";
		}
	}

	/**
	 * Writes data to a session
	 *
	 * @param mixed $sessID
	 * @param mixed $sessData
	 * @return bool
	 */
	function write($sessID,$sessData) {
		$newExp = time() + $this->lifeTime;
		$res = $this->db->query("SELECT * FROM `site_sessions`
                            WHERE `session_id` = '$sessID'");
		$num=$res->num_rows;
		$res->close();

		if($num) {
			$this->db->query("UPDATE `site_sessions`
                         SET `session_expires` = '$newExp',
                         `session_data` = '$sessData'
                         WHERE `session_id` = '$sessID'");
			if($this->db->affected_rows)
				return true;
		}else {
			$this->db->query("INSERT INTO `site_sessions`(
                         `session_id`,
                         `session_expires`,
                         `session_data`)
                         VALUES(
                         '$sessID',
                         '$newExp',
                         '$sessData')");
			if($this->db->affected_rows)
				return true;
		}
		return false;
	}

	/**
	 * Destroys a session
	 *
	 * @param mixed $sessID
	 * @return bool
	 */
	function destroy($sessID) {
		$this->db->query("DELETE FROM `site_sessions` WHERE `session_id` = '$sessID'");
		if($this->db->affected_rows)
			return true;
		return false;
	}

	/**
	 * Cleans old sessions
	 *
	 * @param mixed $sessMaxLifeTime
	 * @return bool
	 */
	function gc($sessMaxLifeTime) {
		$this->db->query("DELETE FROM `site_sessions` WHERE `session_expires` < ".time());
		return $this->db->affected_rows;
	}
}

$session = new session($db);
session_set_save_handler(array(&$session,"open"),
                         array(&$session,"close"),
                         array(&$session,"read"),
                         array(&$session,"write"),
                         array(&$session,"destroy"),
                         array(&$session,"gc"));
?>