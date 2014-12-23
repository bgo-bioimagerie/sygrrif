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
 		`type_id` int(11) NOT NULL,
		`url` varchar(50) NOT NULL DEFAULT '',
		`note` varchar(200) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addPublication($type_id, $url, $note){
		$sql = "insert into biblio_publication(type_id, url, note)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($type_id, $url, $note));
	}
	
	public function getPublication($id){
		$sql = "select * from biblio_publication where id=?;";
		$req = $this->runRequest($sql);
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}