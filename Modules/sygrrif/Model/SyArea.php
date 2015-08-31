<?php

require_once 'Framework/Model.php';

/**
 * Class defining the area model
 *
 * @author Sylvain Prigent
 */
class SyArea extends Model {

	
	/**
	 * Create the area table
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
	
	/**
	 * Get the areas list
	 * @param string $sortEntry Sort entry
	 * @return multitype: tables of areas
	 */
	public function areas($sortEntry){
		$sql = "select * from sy_areas order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * Get the area info given it ID
	 * @param number $id Area ID
 	 * @return mixed|string Area info or error message
	 */
	public function getArea($id){
	
		$sql = "select * from sy_areas where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ();
		else
			return "not found";
	}
	
	/**
	 * Get the area name given it ID
	 * @param number $id Area ID
 	 * @return mixed|string Area info or error message
	 */
	public function getAreaName($id){

		$sql = "select name from sy_areas where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1){
			$tmp = $data->fetch ();
			return $tmp[0];
		}
		else{
			return "not found";
			}
	}
	
	/**
	 * Get ID and Name of areas that are not restricted to managers
	 * @return multitype: Areas info
	 */
	public function getUnrestrictedAreasIDName(){
		$sql = "select id, name from sy_areas where restricted=0;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * 
	 * Get ID and Name of areas of all areas
	 * @return multitype: Areas info
	 */
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
	
	/**
	 * Import an area (method used to import GRR database)
	 * @param number $id
	 * @param string $name
	 * @param number $display_order
	 * @param number $restricted
	 */
	public function importArea($id, $name, $display_order, $restricted){
	
		if ($this->isAreaId($id)){
			$this->updateArea($id, $name, $display_order, $restricted);
		}
		else{
			$sql = "insert into sy_areas(id, name, display_order, restricted)"
				. " values(?,?,?,?)";
			$user = $this->runRequest($sql, array($id, $name, $display_order, $restricted));
		}
	}
	
	/**
	 * Check if an area exists
	 * @param string $name
	 * @return boolean
	 */
	public function isArea($name){
		$sql = "select * from sy_areas where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Check if an area exists
	 * @param number $id
	 * @return boolean
	 */
	public function isAreaId($id){
		$sql = "select * from sy_areas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}

	/**
	 * Add an area if not exists
	 * @param string $name
	 * @param number $display_order
	 * @param number $restricted
	 */
	public function setArea($name, $display_order, $restricted){
		if (!$this->isArea($name)){
			$this->addArea($name, $display_order, $restricted);
		}
	}
	
	/**
	 * Update a area info
	 * @param number $id ID of the area to edit 
	 * @param string $name New name
	 * @param number $display_order New display order
	 * @param number $restricted New restriction
	 */
	public function updateArea($id, $name, $display_order, $restricted){
		$sql = "update sy_areas set name= ?, display_order=?, restricted=?
									  where id=?";
		$this->runRequest($sql, array($name, $display_order, $restricted, $id));
	}
	
	/**
	 * Get an area ID from it name
	 * @param string $name
	 * @return Number Area ID 
	 */
	public function getAreaFromName($name){
		$sql = "select id from sy_areas where name=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0] ;
		}
		else
			return 0;
	}

	/**
	 * Get the smallest area ID in the table
	 * @return Number Smallest ID
	 */
	public function getSmallestID(){
		$sql = "select id from sy_areas";
		$req = $this->runRequest($sql);
		$tmp = $req->fetch();
		return $tmp[0] ;

	}
	
	/**
	 * Get the smallest unrestricted area ID in the table
	 * @return Number Smallest ID
	 */
	public function getSmallestUnrestrictedID(){
		$sql = "select id from sy_areas where restricted=0";
		$req = $this->runRequest($sql);
		$tmp = $req->fetch();
		return $tmp[0] ;
	}
	
	/**
	 * Remove an area
	 * @param number $id Area ID
	 */
	
	public function delete($id){
		$sql="DELETE FROM sy_areas WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}

}