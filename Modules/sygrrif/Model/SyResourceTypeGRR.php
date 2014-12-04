<?php
require_once 'Framework/ModelGRR.php';

/**
 * Class defining the GRR resource model
 *
 * @author Sylvain Prigent
 */
class SyResourceTypeGRR extends ModelGRR {
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sy_j_resource_type` (
		`grr_id_ressource` int(11) NOT NULL,
		`type_id` int(11) NOT NULL,
		PRIMARY KEY (`grr_id_ressource`)
		);
		CREATE TABLE IF NOT EXISTS `sy_resource_type` (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(30) NOT NULL DEFAULT '',
  		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	public function createDefaultTypes() {
		$this->addType ( "Calandar" );
		$this->addType ( "Quantity" );
	}
	public function addType($name) {
		$sql = "INSERT INTO sy_resource_type (name)
				 VALUES(?)";
		$pdo = $this->runRequest ( $sql, array (
				$name 
		) );
		return $pdo;
	}
	public function getTypeId($typename) {
		$sql = "select id from sy_resource_type where name=?";
		$data = $this->runRequest ( $sql, array (
				$typename 
		) );
		if ($data->rowCount () == 1)
			return $data->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the resource type using the given name" );
	}
	public function getTypeName($typeId) {
		$sql = "select name from sy_resource_type where id=?";
		$data = $this->runRequest ( $sql, array (
				$typeId
		) );
		if ($data->rowCount () == 1)
			return $data->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the resource type using the given id" );
	}
	public function getResourceTypeID($resourceID) {
		$sql = "select type_id from sy_j_resource_type where grr_id_ressource=?";
		$data = $this->runRequest ( $sql, array (
				$resourceID 
		) );
		if ($data->rowCount () == 1)
			return $data->fetch ()[0]; // get the first line of the result
		else
			return - 1;
	}
	public function addResourceType($idResource, $idType) {
		$sql = "insert into sy_j_resource_type(grr_id_ressource, type_id)" . " values(?, ?)";
		$this->runRequest ( $sql, array (
				$idResource,
				$idType 
		) );
	}
}