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
		`icon` varchar(40) NOT NULL DEFAULT '',		
		PRIMARY KEY (`id`)
		);

		CREATE TABLE IF NOT EXISTS `core_datamenu` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(40) NOT NULL DEFAULT '',
		`link` varchar(150) NOT NULL DEFAULT '',
		`usertype` int(11) NOT NULL,
		`icon` varchar(40) NOT NULL DEFAULT '',			
		PRIMARY KEY (`id`)
		);
		";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addCoreDefaultMenus(){
		if (!$this->isAdminMenu("Modules")){
			$sql = "INSERT INTO core_adminmenu (name, link, icon) VALUES(?,?,?)";
			$this->runRequest($sql, array("Modules", "modulesmanager","glyphicon-th-large"));
		}
		
		if (!$this->isDataMenu("users/institutions")){
			$sql = "INSERT INTO core_datamenu (name, link, usertype, icon) VALUES(?,?,?,?)";
			$this->runRequest($sql, array("users/institutions", "users", 3, "glyphicon-user"));
		}
	}
	
	// Admin menu methods
	public function addAdminMenu($name, $link, $icon){
		$sql = "INSERT INTO core_adminmenu (name, link, icon) VALUES(?,?,?)";
		$pdo = $this->runRequest($sql, array($name, $link, $icon));
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
		$sql = "select name, link, icon from core_adminmenu";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	// data menu methods
	public function addDataMenu($name, $link, $usertype, $icon){
		$sql = "INSERT INTO core_datamenu (name, link, usertype, icon) VALUES(?,?,?,?)";
		$pdo = $this->runRequest($sql, array($name, $link, $usertype, $icon));
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
	
	public function setDataMenu($name, $link, $usertype, $icon){
		
		//echo "user type = ". $usertype . "</br>";
		$exists = $this->isDataMenu($name);
		if (!$exists && $usertype == 0){
			//echo "do nothing </br>";
			return;
		}
		if ($exists && $usertype == 0){
			//echo "remove </br>";
			$this->removeDataMenu($name);
			return;
		}
		if (!$exists && $usertype > 0){
			//echo "add data menu </br>";
			$this->addDataMenu($name, $link, $usertype, $icon);
			return;
		}
		if ($exists && $usertype > 0){
			//echo "update nothing </br>";
			$this->updateDataMenu($name, $link, $usertype, $icon);
			return;
		}
	}
	
	public function updateDataMenu($name, $link, $usertype, $icon){
		$sql = "select id from core_datamenu where name=?";
		$req = $this->runRequest($sql, array($name));
		$id = $req->fetch()[0];
		
		$sql = "update core_datamenu set name=?, link=?, usertype=?, icon=? where id=?";
		$this->runRequest($sql, array("".$name."", "".link."",
				                              "".usertype."", "".icon."", $id));
	}
	
	public function getDataMenusUserType($name){
		if ($this->isDataMenu($name)){
			$sql = "select usertype from core_datamenu where name=?";
			$data = $this->runRequest($sql, array($name));
			return $data->fetch()[0];
		}
		return 0;

	}
	
	public function getDataMenus($user_status=1){
		$sql = "select name, link, icon from core_datamenu where usertype<=?";
		$data = $this->runRequest($sql, array($user_status));
		return $data->fetchAll();
	}
}

