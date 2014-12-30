<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Entries.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesArticle extends Entries {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_article` (
		`id_publi` int(11) NOT NULL,
		`journal_id` int(11) NOT NULL,
		`pages` varchar(15) NOT NULL,
		`volume` int(11) NOT NULL,		
		PRIMARY KEY (`id_publi`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntry(){
		$pubicationInfos['journal_id'] = 0;
		$pubicationInfos['pages'] = "";
		$pubicationInfos['volume'] = "";
		return $pubicationInfos;
	}
	
	public function getDescription($id_publi){
		$entry = $this->getEntry($id_publi);
		
		$modelJournal = new Journal();
		$jounalName = $modelJournal->getJournal($entry['journal_id'])['name'];
		
		$desc = "<i>". $jounalName . "</i>, vol. "
				. $entry['volume'] . ", pp. "
						. $entry['pages'];
		
		return $desc;
	
	}
	
	public function editEntry($pubicationInfos){
		$publiID = $pubicationInfos["publi_id"];
		$journal_id = $pubicationInfos["journal_id"];
		$pages = $pubicationInfos["pages"];
		$volume = $pubicationInfos["volume"];
	
		//echo "journal id = " . $journal_id; 
		//echo "publiID = " . $publiID;
		
		if ($journal_id == 0){
			$modelJ = new Journal();
			$journal_id = $modelJ->addJournal($pubicationInfos["journal"]);
		}
		
		// set the publication info
		if ($pubicationInfos["id"] == "" || $pubicationInfos["id"] == 0){
			$this->addEntry($publiID, $journal_id, $pages, $volume);
		}
		else{
			$this->updateEntry($publiID, $journal_id, $pages, $volume);
		}
	}
	
	public function addEntry($id_publi, $journal_id, $pages, $volume){
		$sql = "insert into biblio_entries_article(id_publi, journal_id, pages, volume)"
				. " values(?,?,?,?)";
		$user = $this->runRequest($sql, array($id_publi, $journal_id, 
				                              $pages, $volume));
	}
	
	public function updateEntry($id_publi, $journal_id, $pages, $volume){
			$sql = "update biblio_entries_article set journal_id=?, pages=?, 
		                                              volume=?
				                          where id_publi=?";
		$this->runRequest($sql, array($journal_id, $pages, $volume, $id_publi));
		
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_article where id_publi=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}