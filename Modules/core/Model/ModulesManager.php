<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class ModulesManager extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_adminmenu` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(40) NOT NULL DEFAULT '',
		`link` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);

		CREATE TABLE IF NOT EXISTS `core_datamenu` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(40) NOT NULL DEFAULT '',
		`link` varchar(150) NOT NULL DEFAULT '',
		`usertype` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);
		";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addCoreDefaultMenus(){
		if (!$this->isAdminMenu("GRR configuration")){
			$sql = "INSERT INTO core_adminmenu (name, link) VALUES(?,?)";
			$this->runRequest($sql, array("GRR configuration", "configgrr"));
		}
		
		if (!$this->isAdminMenu("Modules")){
			$sql = "INSERT INTO core_adminmenu (name, link) VALUES(?,?)";
			$this->runRequest($sql, array("Modules", "modulesmanager"));
		}
		
		if (!$this->isDataMenu("users/institutions")){
			$sql = "INSERT INTO core_datamenu (name, link) VALUES(?,?)";
			$this->runRequest($sql, array("users/institutions", "users"));
		}
	}
	
	// Admin menu methods
	public function addAdminMenu($name, $link){
		$sql = "INSERT INTO core_adminmenu (name, link) VALUES(?,?)";
		$pdo = $this->runRequest($sql, array($name, $link));
		return $pdo;
	}
	
	public function removeAdminMenu($name){
		$sql = "DELETE FROM core_adminmenu
				WHERE name='".$name."';";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function isAdminMenu($name){
		$sql = "select id from core_adminmenu where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function getAdminMenus(){
		$sql = "select name, link from core_adminmenu";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	// data menu methods
	public function addDataMenu($name, $link, $usertype){
		$sql = "INSERT INTO core_datamenu (name, link, usertype) VALUES(?,?,?)";
		$pdo = $this->runRequest($sql, array($name, $link, $usertype));
		return $pdo;
	}
	
	public function removeDataMenu($name){
		$sql = "DELETE FROM core_datamenu
				WHERE name='".$name."';";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function isDataMenu($name){
		$sql = "select id from core_datamenu where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function getDataMenus(){
		$sql = "select name, link from core_datamenu";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
}

