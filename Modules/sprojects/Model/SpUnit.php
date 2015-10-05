<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model for consomable module
 *
 * @author Sylvain Prigent
 */
class SpUnit extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sp_units` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`address` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty Unit
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultUnit(){
	
		if(!$this->isUnit("--")){
			$sql = "INSERT INTO sp_units (name, address) VALUES(?,?)";
			$this->runRequest($sql, array("--", "--"));
		}
	}
	
	/**
	 * get units informations
	 * 
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getUnits($sortentry = 'id'){
		 
		$sql = "select * from sp_units order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the names of all the units
	 *
	 * @return multitype: array
	 */
	public function unitsName(){
			
		$sql = "select name from sp_units";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * Get the units ids and names
	 *
	 * @return array
	 */
	public function unitsIDName(){
			
		$sql = "select id, name from sp_units";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * add a unit to the table
	 *
	 * @param string $name name of the unit
	 * @param string $address address of the unit
	 */
	public function addUnit($name, $address){
		
		$sql = "insert into sp_units(name, address)"
				. " values(?, ?)";
		$user = $this->runRequest($sql, array($name, $address));		
	}
	
	/**
	 * update the information of a unit
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 * @param string $address New Address of the unit
	 */
	public function editUnit($id, $name, $address){
		
		$sql = "update sp_units set name=?, address=? where id=?";
		$unit = $this->runRequest($sql, array("".$name."", "".$address."", $id));
	}
	
	
	public function isUnit($name){
		$sql = "select * from sp_units where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setUnit($name, $address){
		if (!$this->isUnit($name)){
			$this->addUnit($name, $address);
		}
	}
	
	/**
	 * get the informations of a unit
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception id the unit is not found
	 * @return mixed array
	 */
	public function getUnit($id){
		$sql = "select * from sp_units where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
    		return $unit->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the unit using the given id = " . $id . "</br>"); 
	}
	
	/**
	 * get the name of a unit
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception if the unit is not found
	 * @return mixed array
	 */
	public function getUnitName($id){
		$sql = "select name from sp_units where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			return "";
		}
	}
	
	/**
	 * get the id of a unit from it's name
	 * 
	 * @param string $name Name of the unit
	 * @throws Exception if the unit connot be found
	 * @return mixed array
	 */
	public function getUnitId($name){
		$sql = "select id from sp_units where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the unit using the given name");
		}
	}

}

