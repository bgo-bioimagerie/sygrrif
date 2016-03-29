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

		$this->runRequest($sql);
		
                $this->addColumn("ca_categories", "display_order", "int(4)", 0);
	}
	
	public function add($name, $displayOrder = 0){ 
		$sql = "INSERT INTO ca_categories(name, display_order) VALUES(?,?)";
		$this->runRequest($sql, array($name, $displayOrder));
	}
	
	public function edit($id, $name, $displayOrder = 0){
		$sql = "update ca_categories set name=?, display_order=? where id=?";
		$this->runRequest($sql, array($name, $displayOrder, $id));
	}
	
	public function getAll(){
		$sql = "SELECT * FROM ca_categories ORDER BY display_order ASC;";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getName($id){
		$sql = "SELECT name FROM ca_categories WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$inter = $req->fetch();
		return $inter[0];
	}
        
        public function getDisplayOrder($id){
		$sql = "SELECT display_order FROM ca_categories WHERE id=?";
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
		$this->runRequest($sql, array($id));
	}
}