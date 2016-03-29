<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';

require_once 'Modules/sprojects/Model/SpItemPricing.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpProject.php';

require_once 'Modules/sprojects/Model/SpBill.php';
require_once 'Modules/sprojects/Model/SpItemsTypes.php';

/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class SpInitDatabase extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){

		$modulesModel = new SpItemPricing();
		$modulesModel->createTable();
		
		$modulesModel = new SpItem();
		$modulesModel->createTable();
		
		$modulesModel = new SpProject();
		$modulesModel->createTable();
		
		$modulesModel = new SpBill();
		$modulesModel->createTable();
		
		$modulesModel = new SpItemsTypes();
		$modulesModel->createTable();
		$modulesModel->createDefault();
		
		$message = 'success';
		return $message;
	}
}

