<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class CaEntry extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `ca_entries` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_category` int(11) NOT NULL,
	    `title` varchar(100) NOT NULL,
		`image_url` varchar(300) NOT NULL,
		`short_desc` text NOT NULL,
		`full_desc` text NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		
		// add columns if no exists
		$sql = "SHOW COLUMNS FROM `ca_entries` LIKE 'image_url'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `ca_entries` ADD `image_url` varchar(300) NOT NULL";
			$pdo = $this->runRequest($sql);
		}
	}
	
	public function add($id_category, $title, $short_desc, $full_desc){ 
		$sql = "INSERT INTO ca_entries(id_category, title, short_desc, full_desc) VALUES(?,?,?,?)";
		$this->runRequest($sql, array($id_category, $title, $short_desc, $full_desc));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setImageUrl($id, $url){
		$sql = "update ca_entries set image_url=? where id=?";
		$this->runRequest($sql, array($url, $id));
	}
	
	public function edit($id, $id_category, $title, $short_desc, $full_desc){
		$sql = "update ca_entries set id_category=?, title=?, short_desc=?, full_desc=? where id=?";
		$this->runRequest($sql, array($id_category, $title, $short_desc, $full_desc, $id));
	}
	
	public function getAll(){
		$sql = "SELECT * FROM ca_entries";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getInfo($id){
		$sql = "SELECT * FROM ca_entries WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$inter = $req->fetch();
		return $inter;
	}
	
	/**
	 * Delete a category
	 * @param number $id Entry ID
	 */
	public function delete($id){
		$sql="DELETE FROM ca_entries WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	public function getCategoryEntries($id){
		$sql = "SELECT * FROM ca_entries WHERE id_category=?";
		$req = $this->runRequest($sql, array($id));
		$inter = $req->fetchAll();
		return $inter;
	}
}