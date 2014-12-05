<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif resource model
 * it uses the GRR resource model
 *
 * @author Sylvain Prigent
 */

class SyResource extends Model {

	/**
	 * Create the unit table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_resources` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`grr_id` int(11) NOT NULL,		
		`name` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addResource($grr_id, $name){
		$sql = "INSERT INTO sy_resources (grr_id, name) VALUES(?, ?)";
		$pdo = $this->runRequest($sql, array($grr_id, $name));
		return $pdo;
	}
	
	public function isResource($grr_id){
		$sql = "select * from sy_resources where grr_id=?";
		$unit = $this->runRequest($sql, array($grr_id));
		if ($unit->rowCount() == 1)
			return true;  // get the first line of the result
		else
			return false;
	}

	public function editResource($grr_id, $name){
		$sql = "update sy_resources set name=? where grr_id=?";
		$this->runRequest($sql, array($name, $grr_id));
	}
	
	/**
	 * Get the resources grr_ids and names
	 *
	 * @return array
	 */
	public function resources(){
			
		$sql = "select grr_id, name from sy_resources";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
}