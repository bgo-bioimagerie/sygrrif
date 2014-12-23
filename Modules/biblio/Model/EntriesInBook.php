<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesInBook extends Model {

	
	/**
	 * Create the book entries table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_inbook` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`title` varchar(50) NOT NULL,
		`chapter` int(4) NOT NULL,
		`pages` varchar(15) NOT NULL,				
		`publisher` int(11) NOT NULL,
		`year` int(4) NOT NULL,
		`volume` int(11) NOT NULL,		
		`series` int(11) NOT NULL,
		`address` varchar(50) NOT NULL,
		`edition` int(4) NOT NULL,				
		`month` int(2) NOT NULL,		
		PRIMARY KEY (`id`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($title, $chapter, $pages, $publisher, $year, 
	                         $volume, $series, $address, $edition, $month){
		$sql = "insert into biblio_entries_inbook(title, chapter, pages, publisher, year, 
				                                  volume, series, address, edition, month)"
				. " values(?,?,?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($title, $chapter, $pages, $publisher, $year, 
	                         $volume, $series, $address, $edition, $month));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_inbook where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}