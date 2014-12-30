<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class Publication extends Model {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_publication` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`type_name` varchar(20) NOT NULL,
		`title` varchar(300) NOT NULL DEFAULT '',
		`month` int(2) NOT NULL,		
		`year` int(4) NOT NULL,
		`url` varchar(50) NOT NULL DEFAULT '',
		`note` varchar(200) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addPublication($type_name, $title, $month, $year, $note, $url = ""){
		$sql = "insert into biblio_publication(type_name, title, month, year, note, url)"
				. " values(?,?,?,?,?,?)";
		$this->runRequest($sql, array($type_name, $title, $month, $year, $note, $url));
		return $this->getDatabase()->lastInsertId();
	} 
	
	public function updatePublication($id, $type_name, $title, $month, $year, $note){
		$sql = "update biblio_publication set type_name=?, title=?, month=?,
		                                      year=?, note=?
				                          where id=?";
		$this->runRequest($sql, array($type_name, $title, $month, $year, $note, $id));
	}
	
	public function setPublicationURL($id, $url){
		$sql = "update biblio_publication set url=? where id=?";
		$this->runRequest($sql, array($url, $id));
	}
	
	public function allPublications(){
		$sql = "select * from biblio_publication order by year;";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getPublication($id){
		$sql = "select * from biblio_publication where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}
	
	public function publicationsOfYear($year){
		$sql = "select * from biblio_publication where year=? order by month;";
		$req = $this->runRequest($sql, array($year));
		return $req->fetchAll();
	}
	
	public function publicationsOfType($typeName){
		$sql = "select * from biblio_publication where type_name=? order by year, month;";
		$req = $this->runRequest($sql, array($typeName));
		return $req->fetchAll();
	}
	
	public function publicationsOfAuthor($author_id){
		$sql = "select * from biblio_publication WHERE id IN (SELECT id_publi FROM biblio_j_author_publi WHERE id_author=?) order by year, month;";
		$req = $this->runRequest($sql, array($author_id));
		return $req->fetchAll();
	}
	

}