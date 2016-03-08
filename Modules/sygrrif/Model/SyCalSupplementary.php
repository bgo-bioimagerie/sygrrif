<?php

require_once 'Framework/Model.php';

/**
 * Model for calendar suplementary informations
 *
 * @author Sylvain Prigent
 */
class SyCalSupplementary extends Model {

	
	/**
	 * Create the calsupplementaries table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_calsupplementaries` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`name` varchar(30) NOT NULL DEFAULT '',
		`mandatory` int(1) NOT NULL,			
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get the supplementaries infos
	 * @param unknown $sortEntry
	 * @return multitype:
	 */
	public function calSups($sortEntry){
		$sql = "select * from sy_calsupplementaries order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * get a supplementary info from it ID
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function getcalSups($id){
	
		$sql = "select * from sy_calsupplementaries where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ();
		else
			return "not found";
	}
	
	/**
	 * get a supplementary name from it ID
	 * @param unknown $id
	 * @return string
	 */
	public function getcalSupName($id){

		$sql = "select name from sy_calsupplementaries where id=?;";
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
	 * Add a supplementary
	 * @param unknown $name
	 * @param unknown $mandatory
	 */
	public function addCalSup($name, $mandatory){
		
		$sql = "insert into sy_calsupplementaries(name, mandatory)"
				. " values(?,?)";
		$user = $this->runRequest($sql, array($name, $mandatory));		
	}
	
	/**
	 * Set a supplementaty (add if not exists update otherwise)
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $mandatory
	 */
	public function setCalSup($id, $name, $mandatory){
	
		if ($this->isCalSupId($id)){
			$this->updateCalSup($id, $name, $mandatory);
		}
		else{
			$sql = "insert into sy_calsupplementaries(id, name, mandatory)"
				. " values(?,?,?)";
			$user = $this->runRequest($sql, array($id, $name, $mandatory));
		}
	}
	
	/**
	 * Check if a suplementary exists from name
	 * @param unknown $name
	 * @return boolean
	 */
	public function isCalSup($name){
		$sql = "select * from sy_calsupplementaries where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Check if a suplementary exists from ID
	 * @param unknown $id
	 * @return boolean
	 */
	public function isCalSupId($id){
		$sql = "select * from sy_calsupplementaries where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Update a supplementary
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $mandatory
	 */
	public function updateCalSup($id, $name, $mandatory){
		$sql = "update sy_calsupplementaries set name= ?, mandatory=?
									  where id=?";
		$this->runRequest($sql, array($name, $mandatory, $id));
	}
	
	/**
	 * Get a supplementary ID from name
	 * @param unknown $name
	 * @return mixed|number
	 */
	public function getCalSupFromName($name){
		$sql = "select id from sy_calsupplementaries where name=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0] ;
		}
		else
			return 0;
	}

	/**
	 * REmove a supplemenary from it ID
	 * @param unknown $id
	 */
	public function delete($id){
		$sql="DELETE FROM sy_calsupplementaries WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	/**
	 * Get the sypplementary data of a given calendar entry
	 * @param number $id
	 * @return array supplementary
	 */
	public function getSupData($id){
		$sql = "select supplementary from sy_calendar_entry where id=?";
		$req = $this->runRequest($sql, array($id));
		$tmp = $req->fetch();
		$sups = explode(";", $tmp[0]);
		$supData = array();
		foreach ($sups as $sup){
			$sup2 = explode(":=", $sup);
			if (count($sup2) == 2){
				$supData[$sup2[0]] = $sup2[1];
			}
		}
		return $supData;
	}
	
	/**
	 * Set the supplementary of a calendar entry
	 * @param unknown $calsupNames
	 * @param unknown $calsupValues
	 * @param unknown $reservation_id
	 */
	public function setEntrySupData($calsupNames, $calsupValues, $reservation_id){
		
		$supData = "";
		for($i = 0 ; $i < count($calsupNames) ; $i++){
			$supData .= $calsupNames[$i] . ":=" . $calsupValues[$i] . ";";
		}
		
		$sql = "update sy_calendar_entry set supplementary=?
									  where id=?";
		$this->runRequest($sql, array($supData, $reservation_id));
		
	}
	
	/**
	 * Get the supplementary summary of calendar entry 
	 * @param unknown $entryID
	 * @return string
	 */
	public function getSummary($entryID){
		
		$text = "";
		// get the entry sup entries
		$supData = $this->getSupData($entryID);
		foreach ($supData as $key => $value){
			$text .= "<b>".$key.": </b>". $value;
		}
		
		return $text;
	}

}