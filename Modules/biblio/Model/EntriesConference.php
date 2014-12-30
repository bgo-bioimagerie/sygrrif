<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Entries.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesConference extends Entries {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_conf` (
		`id_publi` int(11) NOT NULL AUTO_INCREMENT,	
		`conference_id` int(11) NOT NULL,
		`pages` varchar(15) NOT NULL,		
		PRIMARY KEY (`id_publi`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntry(){
		$pubicationInfos['conference_id'] = "";
		$pubicationInfos['pages'] = "";
		return $pubicationInfos;
	}
	
	public function getDescription($id_publi){
		$entry = $this->getEntry($id_publi);
		
		$modelConf = new Conference();
		$confName = $modelConf->getConference($entry['conference_id'])['name'];
	
		//echo "conf name = " . $confName . "</br>";
		
		$desc = "<i>". $confName . "</i>, pp. "
						. $entry['pages'];
		return $desc;
	
	}
	
	public function editEntry($pubicationInfos){
	
		$id_publi = $pubicationInfos["publi_id"];
		$conference_id = $pubicationInfos["conference_id"];
		$pages = $pubicationInfos["pages"];
	
		if ($conference_id == "" || $conference_id == 0){
			$modelJ = new Conference();
			$conference_id = $modelJ->addConference($pubicationInfos["conference"]);
		}
		
		echo "conference id = " . $conference_id . "</br>";
		
		$model = new EntriesConference();
		if ($pubicationInfos["id"] == "" || $pubicationInfos["id"] == 0){
			$this->addEntry($id_publi, $conference_id, $pages);
		}
		else{
			$this->updateEntry($id_publi, $conference_id, $pages);
		}
	}
	
	public function addEntry($id_publi, $conference_id, $pages){
		$sql = "insert into biblio_entries_conf(id_publi, conference_id, pages)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($id_publi, $conference_id, $pages));
	}
	
	public function updateEntry($id_publi, $conference_id, $pages){
		$sql = "update biblio_entries_conf set conference_id=?, pages=?"
				. " where id_publi=?";
		$user = $this->runRequest($sql, array($conference_id, $pages, $id_publi));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_conf where id_publi=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}