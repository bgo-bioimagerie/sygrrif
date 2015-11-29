<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
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
		`name` varchar(150) NOT NULL DEFAULT '',
		`address` varchar(350) NOT NULL DEFAULT '',
		`id_belonging` int(11) NOT NULL,		
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		
		
		// add columns if no exists
		$sql = "SHOW COLUMNS FROM `sp_units` LIKE 'id_belonging'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_units` ADD `id_belonging` int(11) NOT NULL DEFAULT 1";
			$pdo = $this->runRequest($sql);
		}
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
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * get units informations
	 * 
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getUnits($sortentry = 'id'){
		 
		$sql = "SELECT units.* ,
    				   belongings.name AS belonging
    			FROM sp_units AS units
    			INNER JOIN sp_belongings AS belongings ON units.id_belonging = belongings.id
    			ORDER BY " . $sortentry . " ASC;";
		
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
	public function addUnit($name, $address, $id_belonging){
		
		$sql = "insert into sp_units(name, address, id_belonging)"
				. " values(?, ?, ?)";
		$user = $this->runRequest($sql, array($name, $address, $id_belonging));		
	}
	
	/**
	 * update the information of a unit
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 * @param string $address New Address of the unit
	 */
	public function editUnit($id, $name, $address, $id_belonging){
		
		$sql = "update sp_units set name=?, address=?, id_belonging=? where id=?";
		$unit = $this->runRequest($sql, array($name, $address, $id_belonging, $id));
	}
	
	/**
	 * Check if a unit exists
	 * @param string $id Unit id
	 * @return boolean
	 */
	public function isUnit($id){
		$sql = "select * from sp_units where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Set a unit (add if not exists)
	 * @param string $name Unit name
	 * @param string $address Unit adress
	 */
	public function set($id, $name, $address, $id_belonging){
		if (!$this->isUnit($id)){
			$this->addUnit($name, $address, $id_belonging);
		}
		else{
			$this->editUnit($id, $name, $address, $id_belonging);
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
    		throw new Exception("Cannot find the unit using the given id"); 
	}
	
	/**
	 * get the informations of a unit
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception id the unit is not found
	 * @return mixed array
	 */
	public function getInfo($id){
		$sql = "select * from sp_units where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the unit using the given id");
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
	
	public function getBelonging($id){
		$sql = "select id_belonging from sp_units where id=?";
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
			throw new Exception("Cannot find the unit using the given name:" . $name );
		}
	}
	
	/**
	 * Delete a unit
	 * @param number $id Unit ID
	 */
	public function delete($id){
		$sql="DELETE FROM sp_units WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}

}

