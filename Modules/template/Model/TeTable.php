<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class TeTable extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `te_table` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `name` varchar(50) NOT NULL,		
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/*
	 * 
	 * Add here the query methods
	 * 
	 */
}