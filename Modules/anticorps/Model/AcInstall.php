<?php

require_once 'Framework/Model.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Source.php';
require_once 'Modules/anticorps/Model/Tissus.php';

/**
 * Class defining methods to install and initialize the core database
 *
 * @author Sylvain Prigent
 */
class AcInstall extends Model {

	/**
	 * Create the anticorps database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		echo " 1 ";
		$anticorpsModel = new Anticorps();
		$pdo = $anticorpsModel->createTable();
		
		echo " 2 ";
		$isotypeModel = new Isotype();
		$pdo = $isotypeModel->createTable();
		
		echo " 3 ";
		$sourceModel = new Source();
		$pdo = $sourceModel->createTable();
		
		echo " 4 ";
		$tissusModel = new Tissus();
		$pdo = $tissusModel->createTable();
		echo " 5 ";
		
		$message = 'success';
		return $message;
	}
}

