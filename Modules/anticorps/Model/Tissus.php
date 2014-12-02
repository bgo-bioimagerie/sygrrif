<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Tissus model
 *
 * @author Sylvain Prigent
 */
class Tissus extends Model {

	/**
	 * Create the isotype table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_lien_tissu_anticorps` (
  				`id` int(11) NOT NULL AUTO_INCREMENT,
  				`espece` varchar(30) NOT NULL,
  				`organe` varchar(30) NOT NULL, 
  				`valide` enum('oui','non') NOT NULL,  
  				`ref_bloc` varchar(30) NOT NULL,
  				`id_anticorps` int(11) NOT NULL,
  				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addTissus($id, $espece, $organe, $valide, $ref_bloc){
		$sql = "insert into ac_lien_tissu_anticorps(id_anticorps, espece, 
				                                    organe, valide, ref_bloc)"
				. " values(?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($id, $espece, $organe, $valide, $ref_bloc));
	}
	
	public function getTissus($anticorpsId){
		$sql = "select * from ac_lien_tissu_anticorps where id_anticorps=?";
		$res = $this->runRequest($sql, array($anticorpsId));
		return $res->fetchAll();
	}
	
}