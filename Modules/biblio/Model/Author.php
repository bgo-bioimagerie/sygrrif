<?php

require_once 'Framework/Model.php';

/**
 * Class defining the author model
 *
 * @author Sylvain Prigent
 */
class Author extends Model {

	
	/**
	 * Create the author table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_authors` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
 		`name` varchar(30) NOT NULL DEFAULT '',
		`firstname` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addAuthor($name, $firstname){
		$sql = "insert into biblio_authors(name, firstname)"
				. " values(?,?)";
		$user = $this->runRequest($sql, array($name, $firstname));
	}
	
	public function authors($sortEntry = "name"){
		$sql = "select * from biblio_authors order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function getAuthor($id){
		$sql = "select * from biblio_authors where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch()[0];
		}
		else{
			return null;
		}
	}
		
	public function isAuthor($name, $firstname){
		$sql = "select * from biblio_authors where name=? AND firstname=?";
		$unit = $this->runRequest($sql, array($name, $firstname));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setAuthor($name, $firstname){
		if (!$this->isAuthor($name, $firstname)){
			$this->addAuthor($name, $firstname);
		}
	}
}