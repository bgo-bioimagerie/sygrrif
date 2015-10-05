<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Responsible model
 *
 * @author Sylvain Prigent
 */
class SpResponsible extends Model {

	/**
	 * Create the Responsible table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sp_responsibles` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_users` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the dafault empty responsible user
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultResponsible(){
	
		$sql = "INSERT INTO sp_responsibles (id_users) VALUES(?)";
		$pdo = $this->runRequest($sql, array(1));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * Add a user in the responsible table
	 * 
	 * @param int $id_user Id of the user to add in the responsible table
	 */
	public function addResponsible($id_user){
		
		// test if the user is already responsible
		$sql = "SELECT EXISTS(SELECT 1 FROM sp_responsibles WHERE id = ?)";
		
		$exists = $this->runRequest($sql, array($id_user));
		$out = $exists->fetch();
		
		if ($out[0] == 0){
			$sql = "insert into sp_responsibles(id_users)"
				   . " values(?)";
			$insertpdo = $this->runRequest($sql, array($id_user));	
		}
	}
	
	/**
	 * Return true is a user is responsible
	 * 
	 * @param int $userId Id of the user test
	 * @return boolean return true if the user is responsible false otherwise
	 */
	public function isResponsible($userId){
		$sql = "SELECT EXISTS(SELECT 1 FROM sp_responsibles WHERE id_users = ?)";
		
		$exists = $this->runRequest($sql, array($userId));
		$out = $exists->fetch();
		
		if ($out[0] == 0){
			return false;
		}
		return true;
	}
	
	public function setResponsible($id_user){
		if (!$this->isResponsible($id_user)){
			$this->addResponsible($id_user);
		}
	}
	
	/**
	 * Get the names and firstname of the responsible users 
	 * 
	 * @return multitype: array of the responsible users
	 */
	public function responsiblesNames(){
		$sql = "SELECT firstname, name FROM sp_users WHERE id IN (SELECT id_users FROM sp_responsibles)";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();

		return $resps;
	}
	
	/**
	 * Get the ids of the responsible users
	 * 
	 * @return multitype: array of the responsible users
	 */
	public function responsiblesIds(){
		$sql = "SELECT id_users FROM sp_responsibles";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();
		
		return $resps;
	}
	
	/** 
	 * return the name of a responsible user
	 * 
	 * @param int $id Id of the user to query
	 * @return mixed array containing the firsname and the name of the responsible user
	 */
	public function responsibleName($id){
		$sql = "SELECT firstname, name FROM sp_users WHERE id=?";
		$respPDO = $this->runRequest($sql, array($id));
		$resp = $respPDO->fetch();
		/// @todo add a throw here
		return $resp;
	}
	
	/**
	 * get the id, firstname and name of the responsibles users 
	 * 
	 * @return multitype: 2D array containing the users informations 
	 */
	public function responsibleSummaries(){
		$sql = "SELECT id, firstname, name FROM sp_users WHERE id IN (SELECT id_users FROM sp_responsibles) ORDER BY name";
		$respPDO = $this->runRequest($sql);
		$resps = $respPDO->fetchAll();

		return $resps;
	}
	
	public function getUserResponsible($user_id){
		 $sql = "SELECT id_responsible FROM sp_users WHERE id=?";
		 $respPDO = $this->runRequest($sql, array($user_id));
		 $tmp = $respPDO->fetch();
		 $respID = $tmp[0];
		 return $this->responsibleName($respID);
	}
}

