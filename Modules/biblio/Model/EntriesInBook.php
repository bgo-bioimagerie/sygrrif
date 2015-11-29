<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Entries.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesInBook extends Entries {

	
	/**
	 * Create the book entries table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_inbook` (
		`id_publi` int(11) NOT NULL AUTO_INCREMENT,	
		`chapter` varchar(150) NOT NULL,
		`pages` varchar(15) NOT NULL,				
		`publisher` int(11) NOT NULL,
		`volume` int(11) NOT NULL,		
		`series` varchar(20) NOT NULL,
		`address` varchar(50) NOT NULL,
		`edition` varchar(50) NOT NULL,						
		PRIMARY KEY (`id_publi`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntry(){
		$pubicationInfos['chapter'] = "";
		$pubicationInfos['pages'] = "";
		$pubicationInfos['publisher'] = "";
		$pubicationInfos['volume'] = "";
		$pubicationInfos['series'] = "";
		$pubicationInfos['address'] = "";
		$pubicationInfos['edition'] = "";
		return $pubicationInfos;
	}
	
	public function getDescription($id_publi){
		$entry = $this->getEntry($id_publi);
		
		$desc = "<b> chap. " . $entry['chapter'] . "</b>" . $entry['publisher'] . ", " . 
		        $entry['edition'] . ", " . $entry['series'] . ", " . 
		        $entry['address'] . ", vol. ". $entry['volume'] . ", pp. " . 
		        $entry['pages'];
		
		return $desc;
	}
	
	public function editEntry($pubicationInfos){
	
		$id_publi = $pubicationInfos["publi_id"];
		$chapter = $pubicationInfos["chapter"];
		$pages = $pubicationInfos["pages"];
		$publisher = $pubicationInfos["publisher"];
		$volume = $pubicationInfos["volume"];
		$series = $pubicationInfos["series"];
		$address = $pubicationInfos["address"];
		$edition = $pubicationInfos["edition"];
	
		$model = new EntriesInBook();
		if ($pubicationInfos["id"] == "" || $pubicationInfos["id"] == 0){
			$this->addEntry($id_publi, $chapter, $pages, $publisher,
					$volume, $series, $address, $edition);
		}
		else{
			$this->updateEntry($id_publi, $chapter, $pages, $publisher,
					$volume, $series, $address, $edition);
		}
	}
	
	public function addEntry($id_publi, $chapter, $pages, $publisher,
	                         $volume, $series, $address, $edition){
		$sql = "insert into biblio_entries_inbook(id_publi, chapter, pages, publisher,
				                                  volume, series, address, edition)"
				. " values(?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($id_publi, $chapter, $pages, $publisher, 
	                         $volume, $series, $address, $edition));
	}
	
	public function updateEntry($id_publi, $chapter, $pages, $publisher,
	                         $volume, $series, $address, $edition){
		$sql = "update biblio_entries_inbook set 
						chapter=?, pages=?, publisher=?,
						volume=?, series=?, address=?, edition=?"
				. " where id_publi=?";
		$user = $this->runRequest($sql, array($chapter, $pages, $publisher,
	                         $volume, $series, $address, $edition, $id_publi));
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_inbook where id_publi=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}