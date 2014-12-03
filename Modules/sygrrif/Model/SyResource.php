<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif resource model
 * it uses the GRR resource model
 *
 * @author Sylvain Prigent
 */
class SyResource extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_j_resource_type` (
		`grr_id_ressource` int(11) NOT NULL	
		`id_type` int(11) NOT NULL					
		PRIMARY KEY (`id`)
		);
				
		CREATE TABLE IF NOT EXISTS `sy_resource_type` (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(30) NOT NULL DEFAULT '',
  		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultTypes(){
		$this->addType("Calandar");
		$this->addType("Quantity");
	}

	public function addType($name){
		$sql = "INSERT INTO sy_resource_type (name)
				 VALUES(?)";
		$pdo = $this->runRequest($sql, array($name));
		return $pdo;
	}
	
}