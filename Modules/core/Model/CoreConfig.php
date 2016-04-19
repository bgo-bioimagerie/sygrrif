<?php

require_once 'Framework/Model.php';

/**
 * Class defining the config model
 *
 * @author Sylvain Prigent
 */
class CoreConfig extends Model {

	/**
	 * Create the table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_config` (
		`id` varchar(30) NOT NULL DEFAULT '',
		`value` text NOT NULL DEFAULT '',
                `id_site` int(11) DEFAULT 1, 
		PRIMARY KEY (`id`)
		);";
		
		$this->runRequest($sql);
                
                $this->addColumn("core_config", "id_site", "int(11)", 1);
	}
	
	/**
	 * Create the application contact
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultConfig(){
	
		$this->setParam("admin_email", "firstname.name@adress.com", 1);
		$this->setParam("user_desactivate", "0", 1);
		$this->setParam("logo", "Themes/logo.jpg", 1);
		$this->setParam("home_title", "Database", 1);
		$this->setParam("home_message", "", 1);
	}
	
	/**
	 * Check if a config key exists
	 */
	public function isKey($key){
		$sql = "select id from core_config where id='".$key."'";
		$unit = $this->runRequest($sql);
		if ($unit->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
	}
	
	/**
	 * Add a config parameter
	 * @param string $key
	 * @param string $value
	 */
	public function addParam($key, $value, $id_site = 1){
		$sql = "INSERT INTO core_config (id, value, id_site) VALUES(?,?,?)";
		$this->runRequest($sql, array($key, $value, $id_site));
	}
	
	/**
	 * Update a parameter
	 * @param string $key
	 * @param string $value
	 */
	public function updateParam($key, $value, $id_site = 1){
		$sql = "update core_config set value=?, id_site=? where id=?";
		$this->runRequest($sql, array($value, $key, $id_site));
	}
	
	/**
	 * Get a parameter
	 * @param string $key
	 * @return string: value
	 */
	public function getParam($key, $id_site = 1){
		$sql = "SELECT value FROM core_config WHERE id=? AND id_site=?";
		$req = $this->runRequest($sql, array($key, $id_site));
		
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];
		}
		else{
			return "";
		}
	}
	
	/**
	 * Set a parameter (add if not exists, otherwise update)
	 * @param string $key
	 * @param string $value
	 */
	public function setParam($key, $value, $id_site = 1){
		if ($this->isKey($key)){
			$this->updateParam($key, $value, $id_site);
		}
		else{
			$this->addParam($key, $value, $id_site);
		}
	}
	
}
	