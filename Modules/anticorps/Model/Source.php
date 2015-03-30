<?php

require_once 'Framework/Model.php';

/**
 * Class defining the source model
 *
 * @author Sylvain Prigent
 */
class Source extends Model {

	/**
	 * Create the source table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_sources` (
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
	public function getSources($sortentry = 'id'){
			
		$sql = "select * from ac_sources order by " . $sortentry . " ASC;";
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
	public function getSource($id){
		$sql = "select * from ac_sources where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();
		else
			throw new Exception("Cannot find the source using the given id:" . $id . "<br/>");
	}
	
	/**
	 * add an source to the table
	 *
	 * @param string $name name of the source
	 *
	 */
	public function addSource($name){
	
		$sql = "insert into ac_sources(nom)"
				. " values(?)";
		$this->runRequest($sql, array($name));
	}
	
	/**
	 * update the information of a source
	 *
	 * @param int $id Id of the source to update
	 * @param string $name New name of the source
	 */
	public function editSource($id, $name){
	
		$sql = "update ac_sources set nom=?where id=?";
		$this->runRequest($sql, array("".$name."", $id));
	}
	
	public function getIdFromName($name){
		$sql = "select id from ac_sources where nom=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];
		}
		else
			return 0;
	}
	
	public function delete($id){
		$sql="DELETE FROM ac_sources WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
}