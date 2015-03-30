<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Espece model
 *
 * @author Sylvain Prigent
 */
class Prelevement extends Model {

	/**
	 * Create the espece table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_prelevements` (
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
	public function getPrelevements($sortentry = 'id'){
			
		$sql = "select * from ac_prelevements order by " . $sortentry . " ASC;";
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
	public function getPrelevement($id){
		$sql = "select * from ac_prelevements where id=?";
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
	public function addPrelevement($name){
	
		$sql = "insert into ac_prelevements(nom)"
				. " values(?)";
		$this->runRequest($sql, array($name));
	}
	
	/**
	 * update the information of a 
	 *
	 * @param int $id Id of the  to update
	 * @param string $name New name of the 
	 */
	public function editPrelevement($id, $name){
	
		$sql = "update ac_prelevements set nom=?where id=?";
		$this->runRequest($sql, array("".$name."", $id));
	}
	
	public function getIdFromName($name){
		$sql = "select id from ac_prelevements where nom=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];
		}
		else{
			return 0;
		}
	}
	
	public function delete($id){
		$sql="DELETE FROM ac_prelevements WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}