<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Status model
 *
 * @author Sylvain Prigent
 */
class Status extends Model {

	/**
	 * Create the Status table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_status` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`nom` varchar(30) NOT NULL,
				`color` varchar(6) NOT NULL,
				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get Statuss informations
	 *
	 * @param string $sortentry Entry that is used to sort the Statuss
	 * @return multitype: array
	 */
	public function getStatus($sortentry = 'id'){
			
		$sql = "select * from ac_status order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the informations of an Status
	 *
	 * @param int $id Id of the Status to query
	 * @throws Exception id the Status is not found
	 * @return mixed array
	 */
	public function getStatu($id){
		$sql = "select * from ac_status where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  
		else
			throw new Exception("Cannot find the Status using the given id");
	}
	
	/**
	 * add an Status to the table
	 *
	 * @param string $name name of the Status
	 * 
	 */
	public function addStatus($name, $color="ffffff"){
	
		$sql = "insert into ac_status(nom, color)"
				. " values(?,?)";
		$this->runRequest($sql, array($name, $color));
	}
	
	public function importStatus($id, $name, $color="ffffff"){
	
		$sql = "insert into ac_status(id, nom, color)"
				. " values(?,?,?)";
		$this->runRequest($sql, array($id, $name, $color));
	}
	
	/**
	 * update the information of a 
	 *
	 * @param int $id Id of the  to update
	 * @param string $name New name of the 
	 */
	public function editStatus($id, $name, $color="ffffff"){
	
		$sql = "update ac_status set nom=?, color=? where id=?";
		$this->runRequest($sql, array("".$name."", $color, $id));
	}
	
	public function getIdFromName($name){
		$sql = "select id from ac_status where nom=?";
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
		$sql="DELETE FROM ac_status WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}