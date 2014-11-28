<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/User.php';

/**
 * Class defining the Responsible model
 *
 * @author Sylvain Prigent
 */
class Responsible extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `responsibles` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_users` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultResponsible(){
	
		$sql = "INSERT INTO responsibles (id_users) VALUES(?)";
		$pdo = $this->runRequest($sql, array(1));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	

	public function addResponsible($id_user){
		
		// test if the user is already responsible
		$sql = "SELECT EXISTS(SELECT 1 FROM responsibles WHERE id = ?)";
		
		$exists = $this->runRequest($sql, array($id_user));
		$out = $exists->fetch();
		
		if ($out[0] == 0){
			$sql = "insert into responsibles(id_users)"
				   . " values(?)";
			$insertpdo = $this->runRequest($sql, array($id_user));	
		}
	}
	
	public function isResponsible($userId){
		$sql = "SELECT EXISTS(SELECT 1 FROM responsibles WHERE id_users = ?)";
		
		$exists = $this->runRequest($sql, array($userId));
		$out = $exists->fetch();
		
		if ($out[0] == 0){
			return false;
		}
		return true;
	}
	
	public function responsiblesNames(){
		$sql = "SELECT firstname, name FROM users WHERE id IN (SELECT id_users FROM responsibles)";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();

		return $resps;
	}
	
	public function responsiblesIds(){
		$sql = "SELECT id_users FROM responsibles";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();
		
		return $resps;
	}
	
	public function responsibleName($id){
		$sql = "SELECT firstname, name FROM users WHERE id=?";
		$respPDO = $this->runRequest($sql, array($id));
		$resp = $respPDO->fetch();
		
		return $resp;
	}
	
	public function responsibleSummaries(){
		$sql = "SELECT id, firstname, name FROM users WHERE id IN (SELECT id_users FROM responsibles)";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();

		return $resps;
	}
	

}

