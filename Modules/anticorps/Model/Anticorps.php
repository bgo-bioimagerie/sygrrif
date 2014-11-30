<?php

require_once 'Framework/Model.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Source.php';

/**
 * Class defining the Anticorps model
 *
 * @author Sylvain Prigent
 */
class Anticorps extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
		
		$sql = "CREATE TABLE IF NOT EXISTS `ac_anticorps` (
  				`id` int(11) NOT NULL AUTO_INCREMENT,
  				`nom` varchar(30) NOT NULL DEFAULT '',
  				`no_h2p2` int(11) NOT NULL DEFAULT '0',
  				`date_recept` DATE NOT NULL,
  				`reference` varchar(30) NOT NULL DEFAULT '',
  				`clone` varchar(30) NOT NULL DEFAULT '',
 				`fournisseur` varchar(30) NOT NULL DEFAULT '',
  				`lot` varchar(30) NOT NULL DEFAULT '',
  				`id_isotype` int(11) NOT NULL DEFAULT '0',
  				`id_source` int(11) NOT NULL DEFAULT '0',
  				`stockage` varchar(30) NOT NULL DEFAULT '',
  				`No_Proto` varchar(30) NOT NULL DEFAULT '',
  				`disponible` enum('oui','non') NOT NULL,
  				PRIMARY KEY (`id`)
				);
				
				CREATE TABLE IF NOT EXISTS `ac_lien_user_anticorps` (
  				`id_anticorps` int(11) NOT NULL,
  				`id_utilisateur` int(11) NOT NULL,	
  				PRIMARY KEY (`id_anticorps`)
				);
				";
		
		$pdo = $this->runRequest($sql);
		return true;
	}
	
	/**
	 * Get the anticorps information
	 *
	 * @param string $sortentry column used to sort the users
	 * @return multitype:
	 */
    public function getAnticorps( $sortentry = 'id' ){
    	$sql = "select * from ac_anticorps order by " . $sortentry . " ASC;";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
	}
	
	public function addAnticorps($nom, $no_h2p2, $date_recept, $reference, $clone,
			                     $fournisseur, $lot, $id_isotype, $id_source, $stockage,
			                     $No_Proto, $disponible ){
		

		$sql = "insert into ac_anticorps(nom, no_h2p2, date_recept, reference, clone,
			                     fournisseur, lot, id_isotype, id_source, stockage,
			                     No_Proto, disponible)"
				. " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
		$pdo = $this->runRequest($sql, array($nom, $no_h2p2, $date_recept, $reference, $clone,
			                     $fournisseur, $lot, $id_isotype, $id_source, $stockage,
			                     $No_Proto, $disponible));
		
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * Get the user info by changing the ids by names
	 *
	 * @param string $sortentry column used to sort the users
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getAnticorpsInfo($sortentry = 'id'){
		$ac = $this->getAnticorps($sortentry);
		 
		 
		$isotypeModel = new Isotype();
		$sourceModel = new Source();
		$tissusModel = new Tissus();
		for ($i = 0 ; $i < count($ac) ; $i++){
			$ac[$i]['isotype'] = $isotypeModel->getIsotype($ac[$i]['id_isotype'])['nom'];
			$ac[$i]['source'] = $sourceModel->getSource($ac[$i]['id_source'])['nom'];
			$ac[$i]['tissus'] = $tissusModel->getTissus($ac[$i]['id']);
			$ac[$i]['proprietaire'] = $this->getOwner($ac[$i]['id']);
			//print_r($ac[$i]['tissus']);
		}
		return $ac;
	}

	public function getOwner($acId){
		//$sql = "select id_utilisateur from ac_lien_user_anticorps where id_anticorps=?";
		
		$sql = "SELECT firstname, name, id FROM core_users WHERE id IN 
				(select id_utilisateur from ac_lien_user_anticorps where id_anticorps=?)";
		
		$user = $this->runRequest($sql, array($acId));
		return $user->fetchAll();
	}
	
	public function addOwner($id_user, $id_anticorps){
		
		$sql = "insert into ac_lien_user_anticorps(id_utilisateur, id_anticorps)"
				. " values(?, ? )";
		$pdo = $this->runRequest($sql, array($id_user, $id_anticorps));
		
		return $this->getDatabase()->lastInsertId();
	}
	
}

