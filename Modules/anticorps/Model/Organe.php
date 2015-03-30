<?php

require_once 'Framework/Model.php';

/**
 * Class defining the source model
 *
 * @author Sylvain Prigent
 */
class Organe extends Model {

	/**
	 * Create the organe table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_organes` (
  				`id` int(11) NOT NULL AUTO_INCREMENT,
  				`nom` varchar(30) NOT NULL,	
  				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	

	/**
	 * get sources informations
	 *
	 * @param string $sortentry Entry that is used to sort the sources
	 * @return multitype: array
	 */
	public function getOrganes($sortentry = 'id'){
			
		$sql = "select * from ac_organes order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the informations of a source
	 *
	 * @param int $id Id of the source to query
	 * @throws Exception id the source is not found
	 * @return mixed array
	 */
	public function getOrgane($id){
		$sql = "select * from ac_organes where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();
		else
			throw new Exception("Cannot find the source using the given id");
	}
	
	/**
	 * add an source to the table
	 *
	 * @param string $name name of the source
	 *
	 */
	public function addOrgane($name){
	
		$sql = "insert into ac_organes(nom)"
				. " values(?)";
		$this->runRequest($sql, array($name));
	}
	
	/**
	 * update the information of a source
	 *
	 * @param int $id Id of the organ to update
	 * @param string $name New name of the source
	 */
	public function editOrgane($id, $name){
	
		$sql = "update ac_organes set nom=?where id=?";
		$this->runRequest($sql, array("".$name."", $id));
	}
	
	public function getIdFromName($name){
		$sql = "select id from ac_organes where nom=?";
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
		$sql="DELETE FROM ac_organes WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}