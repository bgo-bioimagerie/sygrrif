<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Entries.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesMisc extends Entries {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_misc` (
		`id_publi` int(11) NOT NULL AUTO_INCREMENT,	
		`howpublished` varchar(50) NOT NULL,		
		PRIMARY KEY (`id_publi`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntry(){
		$pubicationInfos['howpublished'] = "";
		return $pubicationInfos;
	}
	
	public function getDescription($id_publi){
		$entry = $this->getEntry($id_publi);
	
		$desc = $entry['howpublished'];
		
		return $desc;
	}
	
	public function editEntry($pubicationInfos){
	
		$id_publi = $pubicationInfos["publi_id"];
		$howpublished = $pubicationInfos["howpublished"];
	
		$model = new EntriesMisc();
		if ($pubicationInfos["id"] == "" || $pubicationInfos["id"] == 0){
			$this->addEntry($id_publi, $howpublished);
		}
		else{
			$this->updateEntry($id_publi, $howpublished);
		}
	}
	
	
	public function addEntry($id_publi, $howpublished){
		$sql = "insert into biblio_entries_misc(id_publi, howpublished)"
				. " values(?,?)";
		$user = $this->runRequest($sql, array($id_publi, $howpublished));
	}
	
	public function updateEntry($id_publi, $howpublished){
		$sql = "update biblio_entries_misc set howpublished=?"
				. " where id_publi=?";
		$user = $this->runRequest($sql, array($howpublished, $id_publi));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_misc where id_publi=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}