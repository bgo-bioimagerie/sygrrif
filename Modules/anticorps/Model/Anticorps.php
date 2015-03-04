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
				`fournisseur` varchar(30) NOT NULL DEFAULT '',
				`id_source` int(11) NOT NULL DEFAULT '0',
				`reference` varchar(30) NOT NULL DEFAULT '',
				`clone` varchar(30) NOT NULL DEFAULT '',
 				`lot` varchar(30) NOT NULL DEFAULT '',
				`id_isotype` int(11) NOT NULL DEFAULT '0',
				`stockage` varchar(30) NOT NULL DEFAULT '',
  				PRIMARY KEY (`id`)
				);
				
				CREATE TABLE IF NOT EXISTS `ac_j_user_anticorps` (
  				`id_anticorps` int(11) NOT NULL,
  				`id_utilisateur` int(11) NOT NULL,	
				`disponible` int(2) NOT NULL,		
				`date_recept` DATE NOT NULL
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
	
	/**
	 * Add an antibody to the database
	 * 
	 * @param unknown $nom
	 * @param unknown $no_h2p2
	 * @param unknown $fournisseur
	 * @param unknown $id_source
	 * @param unknown $reference
	 * @param unknown $clone
	 * @param unknown $lot
	 * @param unknown $id_isotype
	 * @param unknown $stockage
	 * @param unknown $disponible
	 * @param unknown $date_recept
	 * @return string
	 */
	public function addAnticorps($nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone, 
								$lot, $id_isotype, $stockage){
		

		$sql = "insert into ac_anticorps(nom, no_h2p2, fournisseur, id_source, reference, 
										 clone, lot, id_isotype, stockage)"
				. " values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$pdo = $this->runRequest($sql, array($nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone, 
								$lot, $id_isotype, $stockage));
		
		return $this->getDatabase()->lastInsertId();
	}
	
	public function updateAnticorps($id, $nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone, 
									$lot, $id_isotype, $stockage){
		$sql = "UPDATE ac_anticorps SET nom=?, no_h2p2=?, fournisseur=?, id_source=?, reference=?, 
										 clone=?, lot=?, id_isotype=?, stockage=?
									WHERE id=?";
		$pdo = $this->runRequest($sql, array($nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone,
				$lot, $id_isotype, $stockage, $id));
	}
	/**
	 * Get the antibody info by changing the ids by names
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
			$tmp = $isotypeModel->getIsotype($ac[$i]['id_isotype']);
			$ac[$i]['isotype'] = $tmp['nom'];
			$tmp = $sourceModel->getSource($ac[$i]['id_source']);
			$ac[$i]['source'] = $tmp['nom'];
			$ac[$i]['tissus'] = $tissusModel->getTissus($ac[$i]['id']);
			$ac[$i]['proprietaire'] = $this->getOwners($ac[$i]['id']);
			//print_r($ac[$i]['tissus']);
		}
		return $ac;
	}

	public function getOwners($acId){
	
		$sql = "SELECT ac_j_user_anticorps.id_utilisateur AS id_user, ac_j_user_anticorps.date_recept AS date_recept, 
					   ac_j_user_anticorps.disponible AS disponible, core_users.name AS name, core_users.firstname AS firstname
					FROM ac_j_user_anticorps
					     INNER JOIN core_users on core_users.id = ac_j_user_anticorps.id_utilisateur
				WHERE ac_j_user_anticorps.id_anticorps=?
				ORDER BY core_users.name";
		
		$user = $this->runRequest($sql, array($acId));
		return $user->fetchAll();
	}
	
	public function addOwner($id_user, $id_anticorps, $date, $disponible){
		
		$sql = "insert into ac_j_user_anticorps(id_utilisateur, id_anticorps, date_recept, disponible)"
				. " values(?, ?, ?, ?)";
		$pdo = $this->runRequest($sql, array($id_user, $id_anticorps, $date, $disponible));
		
		return $this->getDatabase()->lastInsertId();
	}
	
	public function removeOwners($id){
		$sql="DELETE FROM ac_j_user_anticorps WHERE id_anticorps = ?";
		$req = $this->runRequest($sql, array($id));
	} 
	
	public function getAnticorpsFromId($id){
		$sql = "SELECT * FROM ac_anticorps WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$anticorps = $req->fetch();
		
		// get owners
		$anticorps["proprietaire"] = $this->getOwners($id);
		
		// get tissus
		$tissusModel = new Tissus();
		$anticorps['tissus'] = $tissusModel->getTissus($id);
		
		return $anticorps;
	}
	
	public function getDefaultAnticorps(){
		
		$anticorps["id"] = "";
		$anticorps["nom"] = "";
		$anticorps["no_h2p2"] = "";
		$anticorps["fournisseur"] = "";
		$anticorps["id_source"] = "";
		$anticorps["reference"] = "";
		$anticorps["clone"] = "";
		$anticorps["lot"] = "";
		$anticorps["id_isotype"] = "";
		$anticorps["stockage"] = "";
		$anticorps["proprietaire"] = array();
		$anticorps['tissus'] = array();
		
		return $anticorps;
	}
}

