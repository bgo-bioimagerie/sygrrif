<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SpItem extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sp_items` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `name` varchar(100) NOT NULL,
		`description` varchar(250) NOT NULL,
		`display_order` int(11) NOT NULL DEFAULT 0,		
		`is_active` int(1) NOT NULL DEFAULT 1,	 
		`type_id` int(11) NOT NULL DEFAULT 1,						
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		
		// add columns if no exists
		$sql = "SHOW COLUMNS FROM `sp_items` LIKE 'display_order'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_items` ADD `display_order` int(11) NOT NULL DEFAULT 0";
			$pdo = $this->runRequest($sql);
		}
		
		$sql = "SHOW COLUMNS FROM `sp_items` LIKE 'is_active'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_items` ADD `is_active` int(1) NOT NULL DEFAULT 1";
			$pdo = $this->runRequest($sql);
		}
		
		$sql = "SHOW COLUMNS FROM `sp_items` LIKE 'type_id'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_items` ADD `type_id` int(11) NOT NULL DEFAULT 1";
			$pdo = $this->runRequest($sql);
		}
	}
	
	/**
	 * add an item to the table
	 *
	 * @param string $name name of the unit
	 */
	public function addItem($name, $description, $display_order, $type_id = 1){
	
		$sql = "insert into sp_items(name, description, display_order, type_id)"
				. " values(?, ?, ?, ?)";
		$this->runRequest($sql, array($name, $description, $display_order, $type_id));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setActive($id, $active){
		$sql = "update sp_items set is_active=? where id=?";
		$unit = $this->runRequest($sql, array($active, $id));
	}
	
	/**
	 * get items informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getItems($sortentry = 'id'){
			
		$sql = "select * from sp_items order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get items informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getActiveItems($sortentry = 'id'){
			
		$sql = "select * from sp_items where is_active=1 order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	
	/**
	 * get the informations of an item
	 *
	 * @param int $id Id of the item to query
	 * @throws Exception id the item is not found
	 * @return mixed array
	 */
	public function getItem($id){
		$sql = "select * from sp_items where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the item using the given id = " . $id);
	}
	
	public function getItemName($id){
		$sql = "select name from sp_items where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the item using the given id");
		}
	}
	
	/**
	 * update the information of an item
	 *
	 * @param int $id Id of the item to update
	 * @param string $name New name of the item
	 */
	public function editItem($id, $name, $description, $display_order, $type_id){
	
		$sql = "update sp_items set name=?, description=?, display_order=?, type_id=? where id=?";
		$unit = $this->runRequest($sql, array("".$name."", $description, $display_order, $type_id, $id));
	}
}