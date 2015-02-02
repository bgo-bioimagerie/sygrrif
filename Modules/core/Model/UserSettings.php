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
		`value` varchar(40) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function getUserSettings($user_id){
		$sql = "select * from core_users_settings where user_id=?";
		$user = $this->runRequest($sql, array($user_id));
		return $user->fetchAll();
	}
	
	public function setSettings($user_id, $setting, $value){
		if (!isSetting($user_id, $setting)){
			$this->addSetting($user_id, $setting, $value);
		}
		else{
			$this->updateSetting($user_id, $setting, $value);
		}
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
	
}