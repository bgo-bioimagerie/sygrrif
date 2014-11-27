<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Status model
 *
 * @author Sylvain Prigent
 */
class Status extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `status` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultStatus(){
		
		$sql = 'INSERT INTO `status` (`name`) VALUES("user")';
		$pdo = $this->runRequest($sql);

		$sql = 'INSERT INTO `status` (`name`) VALUES("manager")';
		$pdo = $this->runRequest($sql);
		
		$sql = 'INSERT INTO `status` (`name`) VALUES("admin")';
		$pdo = $this->runRequest($sql);
		
		return $pdo;
				
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	public function allStatus(){
		$sql = "select name from status";
		$status = $this->runRequest($sql);
		return $status->fetchAll();
	}
	
	public function statusIDName(){
		$sql = "select id, name from status";
		$status = $this->runRequest($sql);
		return $status->fetchAll();
	}
	
	public function getStatusName($id){
		//echo "id status = " . $id;
		$sql = "select name from status where id=?";
		$status = $this->runRequest($sql, array($id));
		if ($status->rowCount() == 1)
			return $status->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the status using the given parameters");
	}

}

