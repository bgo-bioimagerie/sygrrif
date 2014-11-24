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

}

