<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model for consomable module
 *
 * @author Sylvain Prigent
 */
class SpItemsTypes extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sp_itemstypes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(100) NOT NULL DEFAULT '',
		`local_name` varchar(100) NOT NULL DEFAULT '',		
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
	public function createDefault(){
	
		
		$this->add("Quantity", "Quantité");
		$this->add("Time minutes", "Temps en minutes");
		$this->add("Time hours", "Temps en heures");
		$this->add("Price", "Prix");

	}
	
	public function getAll(){
		$sql = "SELECT * FROM sp_itemstypes ORDER BY local_name ASC;";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getLocalName($id){
		$sql = "SELECT local_name FROM sp_itemstypes WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$f = $req->fetch();
		return $f[0];
	}
	
	public function add($name, $local_name){
		
		if(!$this->exists($name)){
			$sql = "INSERT INTO sp_itemstypes (name, local_name) VALUES(?, ?)";
			$this->runRequest($sql, array($name, $local_name));
		}
	}
	
	public function exists($name){
		$sql = "select * from sp_itemstypes where name=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1)
			return true;
		else
			return false;
	}
}

