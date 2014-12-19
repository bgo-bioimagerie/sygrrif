<?php

require_once 'Framework/ModelGRR.php';

/**
 * Class defining the GRR area model
 *
 * @author Sylvain Prigent
 */
class SyArea extends Model {

	
	/**
	 * Create the unit table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_areas` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`name` varchar(30) NOT NULL DEFAULT '',
		`display_order` int(11) NOT NULL,
		`restricted` tinyint(1) NOT NULL,			
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function areas($sortEntry){
		$sql = "select * from sy_areas order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	
	public function getArea($id){
	
		$sql = "select * from sy_areas where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ();
		else
			return "not found";
	}
	
	public function getAreaName($id){

		$sql = "select name from sy_areas where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ()[0];
		else
			return "not found";
	}
	
	public function getAreasIDName(){
		$sql = "select id, name from sy_areas;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * add a Area to the table
	 *
	 * @param string $name name of the Area
	 */
	private function addArea($name, $display_order, $restricted){
		
		$sql = "insert into sy_areas(name, display_order, restricted)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($name, $display_order, $restricted));		
	}
	
	public function importArea($id, $name, $display_order, $restricted){
	
		$sql = "insert into sy_areas(id, name, display_order, restricted)"
				. " values(?,?,?,?)";
		$user = $this->runRequest($sql, array($id, $name, $display_order, $restricted));
	}
	
	public function isArea($name){
		$sql = "select * from sy_areas where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}

	public function setArea($name, $display_order, $restricted){
		if (!$this->isArea($name)){
			$this->addArea($name, $display_order, $restricted);
		}
	}
	
	public function updateArea($id, $name, $display_order, $restricted){
		$sql = "update sy_areas set name= ?, display_order=?, restricted=?
									  where id=?";
		$this->runRequest($sql, array($name, $display_order, $restricted, $id));
	}
	
	public function getAreaFromName($name){
		$sql = "select id from sy_areas where name=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1)
			return $req->fetch()[0] ;
		else
			return 0;
	}


}