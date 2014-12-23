<?php

require_once 'Framework/Model.php';

/**
 * Class defining the journal model
 *
 * @author Sylvain Prigent
 */
class Journal extends Model {

	
	/**
	 * Create the journal table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_journals` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`name` varchar(50) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addJournal($name){
		$sql = "insert into biblio_journals(name)"
				. " values(?)";
		$user = $this->runRequest($sql, array($name));
	}
	
	public function journals($sortEntry = "name"){
		$sql = "select * from biblio_journals order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function getJournal($id){
		$sql = "select * from biblio_journals where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch()[0];
		}
		else{
			return null;
		}
	}
		
	public function isJournal($name){
		$sql = "select * from biblio_journals where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setJournal($name){
		if (!$this->isJournal($name)){
			$this->addJournal($name);
		}
	}
}