<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class Unit extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `units` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`adress` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function getUnits($sortentry = 'id'){
		 
		$sql = "select * from units order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function addUnit($name, $address){
		
		$sql = "insert into units(name, adress)"
				. " values(?, ?)";
		$user = $this->runRequest($sql, array($name, $address));		
	}

}

