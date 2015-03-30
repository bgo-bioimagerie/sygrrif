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
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_j_tissu_anticorps` (
  				`id` int(11) NOT NULL AUTO_INCREMENT,
				`id_anticorps` int(11) NOT NULL,
  				`espece` int(11) NOT NULL,
  				`organe` int(11) NOT NULL, 
  				`status` int(1) NOT NULL,  
  				`ref_bloc` varchar(30) NOT NULL,
				`dilution` varchar(30) NOT NULL,
				`temps_incubation` varchar(30) NOT NULL,
  				`ref_protocol` varchar(30) NOT NULL,
				`prelevement` int(1) NOT NULL,
  				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addTissus($id_anticorps, $espece, $organe, $status, $ref_bloc, $dilution, $temps_incubation, $ref_protocol, $prelevement){
		$sql = "insert into ac_j_tissu_anticorps(id_anticorps, espece, 
				                                    organe, status, ref_bloc,
													dilution, temps_incubation, ref_protocol, prelevement)"
				. " values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($id_anticorps, $espece, $organe, $status, $ref_bloc, $dilution, $temps_incubation, $ref_protocol, $prelevement));
	}
	
	public function getTissus($id_anticorps){
		
		$sql = "SELECT ac_j_tissu_anticorps.id AS id, 
					   ac_j_tissu_anticorps.id_anticorps AS id_anticorps, 	
				       ac_j_tissu_anticorps.status AS status,
				       ac_j_tissu_anticorps.ref_bloc AS ref_bloc,
				       ac_j_tissu_anticorps.dilution AS dilution,
				       ac_j_tissu_anticorps.temps_incubation AS temps_incubation,
					   ac_j_tissu_anticorps.ref_protocol AS ref_protocol,	
					   ac_especes.nom AS espece, ac_especes.id AS espece_id,
					   ac_organes.nom AS organe, ac_organes.id AS organe_id,
					   ac_prelevements.nom AS prelevement, ac_prelevements.id AS prelevement_id 			
				FROM ac_j_tissu_anticorps
				INNER JOIN ac_especes on ac_j_tissu_anticorps.espece = ac_especes.id
				INNER JOIN ac_organes on ac_j_tissu_anticorps.organe = ac_organes.id
				INNER JOIN ac_prelevements on ac_j_tissu_anticorps.prelevement = ac_prelevements.id
				WHERE ac_j_tissu_anticorps.id_anticorps=?";
		
		//$sql = "select * from ac_j_tissu_anticorps where id_anticorps=?";
		$res = $this->runRequest($sql, array($id_anticorps));
		return $res->fetchAll();
		
	}
	
	public function removeTissus($id){
		$sql="DELETE FROM ac_j_tissu_anticorps WHERE id_anticorps = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
}