<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/bioseapp/Model/BiProject.php';
require_once 'Modules/bioseapp/Model/BiProjectData.php';
require_once 'Modules/bioseapp/Model/BiRight.php';

/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class BiInstall extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new BiProject();
		$modulesModel->createTable();
                
                $modulesModelR = new BiRight();
		$modulesModelR->createTable();
                
                $modulesModelP = new BiProjectData();
		$modulesModelP->createTable();
                
                
		$message = 'success';
		return $message;
	}
}

