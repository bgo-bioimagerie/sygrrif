<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SuItem extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `su_items` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `name` varchar(100) NOT NULL,
		`description` varchar(250) NOT NULL,
		`is_active` int(1) NOT NULL,		
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * add an item to the table
	 *
	 * @param string $name name of the unit
	 */
	public function addItem($name, $description){
	
		$sql = "insert into su_items(name, description, is_active)"
				. " values(?, ?, ?)";
		$this->runRequest($sql, array($name, $description, 1));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setActive($id, $active){
		$sql = "update su_items set is_active=? where id=?";
		$unit = $this->runRequest($sql, array($active, $id));
	}
	
	/**
	 * get items informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getItems($sortentry = 'id'){
			
		$sql = "select * from su_items order by " . $sortentry . " ASC;";
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
			
		$sql = "select * from su_items where is_active=1 order by " . $sortentry . " ASC;";
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
		$sql = "select * from su_items where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the item using the given id");
	}
	
	public function getItemName($id){
		$sql = "select name from su_items where id=?";
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
	public function editItem($id, $name, $description){
	
		$sql = "update su_items set name=?, description=? where id=?";
		$unit = $this->runRequest($sql, array("".$name."", $description, $id));
	}
}