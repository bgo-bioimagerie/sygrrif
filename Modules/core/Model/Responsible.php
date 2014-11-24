<?php

require_once 'Framework/Model.php';

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

}

