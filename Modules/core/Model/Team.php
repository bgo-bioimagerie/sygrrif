<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Team model
 *
 * @author Sylvain Prigent
 */
class Team extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `teams` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`adress` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}

}

