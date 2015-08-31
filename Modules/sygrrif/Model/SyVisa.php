<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Visa model
 *
 * @author Sylvain Prigent
 */
class SyVisa extends Model {

	/**
	 * Create the table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_visas` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty Visa
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultVisa(){
		$this->setVisa("--");
	}
	
	/**
	 * get visas informations
	 * 
	 * @param string $sortentry Entry that is used to sort the visas
	 * @return multitype: array
	 */
	public function getVisas($sortentry = 'id'){
		 
		$sql = "select * from sy_visas order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the names of all the visas
	 *
	 * @return multitype: array
	 */
	public function visasName(){
			
		$sql = "select name from sy_visas";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * Get the visas ids and names
	 *
	 * @return array
	 */
	public function visasIDName(){
			
		$sql = "select id, name from sy_visas";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * add a visa to the table
	 *
	 * @param string $name name of the visa
	 */
	public function addVisa($name){
		
		$sql = "insert into sy_visas(name)"
				. " values(?)";
		$user = $this->runRequest($sql, array($name));		
	}
	
	/**
	 * Check if a visa exists
	 * @param unknown $name
	 * @return boolean
	 */
	public function isVisa($name){
		$sql = "select * from sy_visas where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Add a visa if not exists
	 * @param unknown $name
	 */
	public function setVisa($name){
		if (!$this->isVisa($name)){
			$this->addVisa($name);
		}
	}
	
	/**
	 * update the information of a visa
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 */
	public function editVisa($id, $name){
		
		$sql = "update sy_visas set name=? where id=?";
		$unit = $this->runRequest($sql, array("".$name."", $id));
	}
	
	/**
	 * get the informations of a visa
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception id the unit is not found
	 * @return mixed array
	 */
	public function getVisa($id){
		$sql = "select * from sy_visas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
    		return $unit->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the visa using the given id"); 
	}
	
	/**
	 * get the name of a visa
	 *
	 * @param int $id Id of the visa to query
	 * @throws Exception if the visa is not found
	 * @return mixed array
	 */
	public function getVisaName($id){
		$sql = "select name from sy_visas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the visa using the given id");
	}
	
	/**
	 * get the id of a visa from it's name
	 * 
	 * @param string $name Name of the unit
	 * @throws Exception if the unit connot be found
	 * @return mixed array
	 */
	public function getVisaId($name){
		$sql = "select id from sy_visas where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the visa using the given name");
	}
	
	/**
	 * Remove a visa
	 * @param number $id
	 */
	public function delete($id){
		$sql="DELETE FROM sy_visas WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}