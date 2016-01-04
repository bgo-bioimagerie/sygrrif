<?php

require_once 'Framework/Model.php';

/**
 * Class defining the catalog category table model. 
 *
 * @author Sylvain Prigent
 */
class CaCategory extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `ca_categories` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `name` varchar(50) NOT NULL,		
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function add($name){ 
		$sql = "INSERT INTO ca_categories(name) VALUES(?)";
		$this->runRequest($sql, array($name));
	}
	
	public function edit($id, $name){
		$sql = "update ca_categories set name=? where id=?";
		$this->runRequest($sql, array($name, $id));
	}
	
	public function getAll(){
		$sql = "SELECT * FROM ca_categories";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getName($id){
		$sql = "SELECT name FROM ca_categories WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$inter = $req->fetch();
		return $inter[0];
	}
	
	/**
	 * Delete a category
	 * @param number $id Category ID
	 */
	public function delete($id){
		$sql="DELETE FROM ca_categories WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}