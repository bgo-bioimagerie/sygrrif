<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesMisc extends Model {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_misc` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`title` varchar(50) NOT NULL,
		`howpublished` varchar(50) NOT NULL,
		`month` int(2) NOT NULL,
		`year` int(4) NOT NULL,		
		PRIMARY KEY (`id`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($title, $howpublished, $month, $year){
		$sql = "insert into biblio_entries_misc(title, howpublished, month, year)"
				. " values(?,?,?,?)";
		$user = $this->runRequest($sql, array($title, $howpublished, $month, $year));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_misc where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}