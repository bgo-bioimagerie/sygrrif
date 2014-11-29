<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Isotype model
 *
 * @author Sylvain Prigent
 */
class Isotype extends Model {

	/**
	 * Create the isotype table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_isotypes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`nom` varchar(30) NOT NULL,
				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get isotypes informations
	 *
	 * @param string $sortentry Entry that is used to sort the isotypes
	 * @return multitype: array
	 */
	public function getIsotypes($sortentry = 'id'){
			
		$sql = "select * from ac_isotypes order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the informations of an isotype
	 *
	 * @param int $id Id of the isotype to query
	 * @throws Exception id the isotype is not found
	 * @return mixed array
	 */
	public function getIsotype($id){
		$sql = "select * from ac_isotypes where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  
		else
			throw new Exception("Cannot find the isotype using the given id");
	}
	
	/**
	 * add an isotype to the table
	 *
	 * @param string $name name of the isotype
	 * 
	 */
	public function addIsotype($name){
	
		$sql = "insert into ac_isotypes(nom)"
				. " values(?)";
		$this->runRequest($sql, array($name));
	}
	
	/**
	 * update the information of a isotype
	 *
	 * @param int $id Id of the isotype to update
	 * @param string $name New name of the isotype
	 */
	public function editIsotype($id, $name){
	
		$sql = "update ac_isotypes set nom=?where id=?";
		$this->runRequest($sql, array("".$name."", $id));
	}
	
}