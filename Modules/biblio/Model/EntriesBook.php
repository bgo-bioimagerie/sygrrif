<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Entries.php';
require_once 'Modules/biblio/Model/commonFunctions.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
class EntriesBook extends Entries {

	
	/**
	 * Create the book entries table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `biblio_entries_book` (
		`id_publi` int(11) NOT NULL AUTO_INCREMENT,	
		`publisher` varchar(50) NOT NULL,	
		`series` varchar(50) NOT NULL,
		`address` varchar(50) NOT NULL,
		`volume` int(3) NOT NULL,		
		`isbn` int(11) NOT NULL, 		
		PRIMARY KEY (`id_publi`)
		);";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntry(){
		$pubicationInfos['publisher'] = "";
		$pubicationInfos['series'] = "";
		$pubicationInfos['address'] = "";
		$pubicationInfos['volume'] = "";
		$pubicationInfos['isbn'] = "";
		return $pubicationInfos;
	}
	
	public function getDescription($id_publi){
		$entry = $this->getEntry($id_publi);
		$desc = $entry['publisher'] . ", " . $entry['series'] . ", " . $entry['address'] . ", vol. " 
				. $entry['volume'] . ", isbn: "
				. $entry['isbn'];
		return $desc;
	} 
	
	public function editEntry($pubicationInfos){
		$id_publi = $pubicationInfos["publi_id"];
		$publisher = $pubicationInfos["publisher"];
		$series = $pubicationInfos["series"];
		$address = $pubicationInfos["address"];
		$volume = $pubicationInfos["volume"];
		$isbn = $pubicationInfos["isbn"];
	
		if ($pubicationInfos["id"] == "" || $pubicationInfos["id"] == 0){
			$this->addEntry($id_publi, $publisher, $series,
					$address, $volume, $isbn);
		}
		else{
			$this->updateEntry($id_publi, $publisher, $series,
					$address, $volume, $isbn);
		}
	}
	
	public function addEntry($id_publi, $publisher, $series, 
							 $address, $volume, $isbn){
		$sql = "insert into biblio_entries_book(id_publi, publisher, 
				                                   series, address, volume, isbn)"
				. " values(?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($id_publi, $publisher, $series, 
							                  $address, $volume, $isbn));
	}
	
 	public function updateEntry($id_publi, $publisher, $series, 
 							 $address, $volume, $isbn){
		$sql = "update biblio_entries_book set publisher=?, series=?,
		                                      address=?, volume=?,
				                              isbn=? 
				                          where id_publi=?";
		$this->runRequest($sql, array($publisher, $series, 
							          $address, $volume, $isbn, $id_publi));
	
	}
	
	public function getEntry($id){
		$sql = "select * from biblio_entries_book where id_publi=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount () == 1){
			return $req->fetch();
		}
		else{
			return null;
		}
	}

}