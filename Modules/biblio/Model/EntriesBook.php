<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesBook extends Model {

	
	/**
	 * Create the book entries table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_book` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`title` varchar(50) NOT NULL,
		`publisher` int(11) NOT NULL,
		`year` int(4) NOT NULL,	
		`series` int(11) NOT NULL,
		`address` varchar(50) NOT NULL,
		`volume` int(3) NOT NULL,		
		`month` int(2) NOT NULL,
		`isbn` int(11) NOT NULL, 		
		PRIMARY KEY (`id`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($title, $publisher, $year, $series, 
							 $address, $volume, $month, $isbn){
		$sql = "insert into biblio_entries_book(title, publisher, year, 
				                                   series, address, volume, month, isbn)"
				. " values(?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($title, $publisher, $year, $series, 
							                  $address, $volume, $month, $isbn));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_book where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}