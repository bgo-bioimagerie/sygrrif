<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Espece model
 *
 * @author Sylvain Prigent
 */
class Espece extends Model {

	/**
	 * Create the espece table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_especes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`nom` varchar(30) NOT NULL,
				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get especes informations
	 *
	 * @param string $sortentry Entry that is used to sort the especes
	 * @return multitype: array
	 */
	public function getEspeces($sortentry = 'id'){
			
		$sql = "select * from ac_especes order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the informations of an espece
	 *
	 * @param int $id Id of the espece to query
	 * @throws Exception id the espece is not found
	 * @return mixed array
	 */
	public function getEspece($id){
		$sql = "select * from ac_especes where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  
		else
			throw new Exception("Cannot find the espece using the given id");
	}
	
	/**
	 * add an espece to the table
	 *
	 * @param string $name name of the espece
	 * 
	 */
	public function addEspece($name){
	
		$sql = "insert into ac_especes(nom)"
				. " values(?)";
		$this->runRequest($sql, array($name));
	}
	
	/**
	 * update the information of a 
	 *
	 * @param int $id Id of the  to update
	 * @param string $name New name of the 
	 */
	public function editespece($id, $name){
	
		$sql = "update ac_especes set nom=?where id=?";
		$this->runRequest($sql, array("".$name."", $id));
	}
	
}