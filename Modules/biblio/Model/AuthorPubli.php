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
		`position` int(3) NOT NULL
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addJointAuthorPubli($id_publi, $id_author, $position){
		$sql = "insert into biblio_j_author_publi(id_publi, id_author, position)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($id_publi, $id_author, $position));
	}
	
	public function setJointAuthorPubli($id_publi, $id_author, $position){
		if ($this->existsLink($id_publi, $id_author)){
			$this->updateJointAuthorPubli($id_publi, $id_author, $position);
		}
		else{
			$this->addJointAuthorPubli($id_publi, $id_author, $position);
		}
	}
	
	public function existsLink($id_publi, $id_author){
		$sql = "select * from biblio_j_author_publi where id_publi=? and id_author=?";
		$req = $this->runRequest($sql, array($id_publi, $id_author));
		if ($req->rowCount() == 1){
			return true;
		}
		else{
			return false;
		}
	} 
	
	public function updateJointAuthorPubli($id_publi, $id_author, $position){
		$sql = "update biblio_j_author_publi set position=? where id_publi=? and id_author=?";
		$this->runRequest($sql, array($position, $id_publi, $id_author));
	}
	
	public function getAuthorsForPubli($id_publi){
		$sql = "select id_author from biblio_j_author_publi where id_publi=? order by position ASC;";
		$req = $this->runRequest($sql, array($id_publi));
		return $req->fetchAll();
	}
	
	public function removeAllAuthors($publi_id){
		$sql = "delete from biblio_j_author_publi where id_publi = ".$publi_id;
		$this->runRequest($sql);
	}
}