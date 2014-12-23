<?php

require_once 'Framework/Model.php';

/**
 * Class defining the joint author publi model
 *
 * @author Sylvain Prigent
 */
class AuthorPubli extends Model {

	
	/**
	 * Create the joint author publi table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_j_author_publi` (
		`id_publi` int(11) NOT NULL,	
 		`id_author` int(11) NOT NULL,
		`position` int(3) NOT NULL,
		PRIMARY KEY (`id_publi`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addJointAuthorPubli($id_publi, $id_author, $position){
		$sql = "insert into biblio_j_author_publi(id_publi, id_author, position)"
				. " values(?,?)";
		$user = $this->runRequest($sql, array($id_publi, $id_author, $position));
	}
	
	public function getAuthorForPubli($id_publi){
		$sql = "select * from biblio_j_author_publi where id_publi=? order by position ASC;";
		$user = $this->runRequest($sql, array($id_publi));
	}
}