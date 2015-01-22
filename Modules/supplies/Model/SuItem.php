<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SuItem extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `su_conso_items` (
		`id` int(11) NOT NULL,
	    `name` int(11) NOT NULL,
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
	public function addItem($name){
	
		$sql = "insert into su_conso_items(name, is_active)"
				. " values(?, ?)";
		$user = $this->runRequest($sql, array($name, 1));
	}
	
	public function setActive($id, $active){
		$sql = "update su_conso_items set is_active=? where id=?";
		$unit = $this->runRequest($sql, array($active, $id));
	}
	
	/**
	 * get items informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getItems($sortentry = 'id'){
			
		$sql = "select * from su_conso_items order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	