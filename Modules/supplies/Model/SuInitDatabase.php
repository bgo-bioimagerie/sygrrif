<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/supplies/Model/SuUser.php';
require_once 'Modules/supplies/Model/SuUnit.php';
require_once 'Modules/supplies/Model/SuPricing.php';
require_once 'Modules/supplies/Model/SuUnitPricing.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';
require_once 'Modules/supplies/Model/SuItem.php';
require_once 'Modules/supplies/Model/SuEntry.php';
require_once 'Modules/supplies/Model/SuResponsible.php';

/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class SuInitDatabase extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new SuUser();
		$modulesModel->createTable();
		$modulesModel->createDefaultUser();
		
		$modulesModel = new SuUnit();
		$modulesModel->createTable();
		$modulesModel->createDefaultUnit();
		
		$modulesModel = new SuPricing();
		$modulesModel->createTable();
		
		$modulesModel = new SuUnitPricing();
		$modulesModel->createTable();

		$modulesModel = new SuItemPricing();
		$modulesModel->createTable();
		
		$modulesModel = new SuItem();
		$modulesModel->createTable();
		
		$modulesModel = new SuEntry();
		$modulesModel->createTable();
		
		$modulesModel = new SuResponsible();
		$modulesModel->createTable();
		$modulesModel->createDefaultResponsible();
		
		$message = 'success';
		return $message;
	}
}

