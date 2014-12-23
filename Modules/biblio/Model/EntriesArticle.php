<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesArticle extends Model {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_article` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`title` varchar(50) NOT NULL,
		`journal_id` int(11) NOT NULL,
		`year` int(4) NOT NULL,
		`pages` varchar(15) NOT NULL,
		`month` int(2) NOT NULL,
		`volume` int(11) NOT NULL,		
		PRIMARY KEY (`id`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($title, $journal_id, $year, $pages, $month, $volume){
		$sql = "insert into biblio_entries_article(title, journal_id, year, pages, month, volume)"
				. " values(?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($title, $journal_id, $year, 
				                              $pages, $month, $volume));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_article where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}