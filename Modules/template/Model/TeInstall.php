<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/template/Model/TeTable.php';


/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class TeInstall extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new TeTable();
		$modulesModel->createTable();
		
		$message = 'success';
		return $message;
	}
}

