<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class UserSettings extends Model {

	/**
	 * Create the user table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_users_settings` (
		`user_id` int(11) NOT NULL,
		`setting` varchar(30) NOT NULL DEFAULT '',
		`value` varchar(40) NOT NULL DEFAULT ''
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function getUserSettings($user_id){
		$sql = "select setting, value  from core_users_settings where user_id=?";
		$user = $this->runRequest($sql, array($user_id));
		$res = $user->fetchAll();
		
		$out = array();
		foreach ($res as $r){
			$out[$r["setting"]] = $r["value"];
		}
		return $out;
	}
	
	public function getUserSetting($user_id, $setting){
		$sql = "select value from core_users_settings where user_id=? and setting=?";
		$user = $this->runRequest($sql, array($user_id, $setting));
		$tmp = $user->fetch();
		return $tmp[0];
	}
	
	public function setSettings($user_id, $setting, $value){
		if (!$this->isSetting($user_id, $setting)){
			$this->addSetting($user_id, $setting, $value);
		}
		else{
			$this->updateSetting($user_id, $setting, $value);
		}
	}
	
	protected function isSetting($user_id, $setting){
		$sql = "select * from core_users_settings where user_id=? and setting=?";
		$req = $this->runRequest($sql, array($user_id, $setting));
		if ($req->rowCount() == 1)
			return true; 
		else
			return false;
	}
	
	protected function addSetting($user_id, $setting, $value){
		$sql = "insert into core_users_settings (user_id, setting, value)
				 VALUES(?,?,?)";
		$this->runRequest($sql, array($user_id, $setting, $value));
	} 
	
	protected function updateSetting($user_id, $setting, $value){
		$sql = "update core_users_settings set value=? where user_id=? and setting=?";
		$this->runRequest($sql, array($value, $user_id, $setting));
	}
	
	public function updateSessionSettingVariable(){
		// add the user settings to the session
		$settings = $this->getUserSettings($_SESSION["id_user"]);
		$_SESSION["user_settings"] = $settings;
	}
}