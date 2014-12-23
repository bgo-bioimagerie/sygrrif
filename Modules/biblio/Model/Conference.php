<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Conference model
 *
 * @author Sylvain Prigent
 */
class Conference extends Model {

	
	/**
	 * Create the conference table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_conferences` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`name` varchar(50) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addConference($name){
		$sql = "insert into biblio_conferences(name)"
				. " values(?)";
		$user = $this->runRequest($sql, array($name));
	}
	
	public function Conferences($sortEntry = "name"){
		$sql = "select * from biblio_conferences order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function getConference($id){
		$sql = "select * from biblio_conferences where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch()[0];
		}
		else{
			return null;
		}
	}
		
	public function isConference($name){
		$sql = "select * from biblio_conferences where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setConference($name){
		if (!$this->isConference($name)){
			$this->addConference($name);
		}
	}
}