<?php

require_once 'Framework/Model.php';

/**
 * Class defining the config model
 *
 * @author Sylvain Prigent
 */
class CoreConfig extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_config` (
		`id` varchar(30) NOT NULL DEFAULT '',
		`value` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty Unit
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultConfig(){
	
		$this->setParam("admin_email", "firstname.name@adress.com");
		$this->setParam("user_desactivate", "0");

	}
	
	public function isKey($key){
		$sql = "select id from core_config where id='".$key."'";
		$unit = $this->runRequest($sql);
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function addParam($key, $value){
		$sql = "INSERT INTO core_config (id, value) VALUES(?,?)";
		$this->runRequest($sql, array($key, $value));
	}
	
	public function updateParam($key, $value){
		$sql = "update core_config set value=? where id=?";
		$this->runRequest($sql, array($value, $key));
	}
	
	public function getParam($key){
		$sql = "SELECT value FROM core_config WHERE id='".$key."'";
		$req = $this->runRequest($sql);
		if ($req->rowCount() == 1)
			return $req->fetch()[0];
		else
			return "";
	}
	
	public function setParam($key, $value){
		if ($this->isKey($key)){
			$this->updateParam($key, $value);
		}
		else{
			$this->addParam($key, $value);
		}
	}
	
}
	