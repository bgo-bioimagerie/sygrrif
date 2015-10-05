<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpPricing.php';
require_once 'Modules/sprojects/Model/SpUnitPricing.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpProject.php';
require_once 'Modules/sprojects/Model/SpResponsible.php';
require_once 'Modules/sprojects/Model/SpBill.php';

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
		
		$modulesModel = new SpUser();
		$modulesModel->createTable();
		$modulesModel->createDefaultUser();
		
		$modulesModel = new SpUnit();
		$modulesModel->createTable();
		$modulesModel->createDefaultUnit();
		
		$modulesModel = new SpPricing();
		$modulesModel->createTable();
		
		$modulesModel = new SpUnitPricing();
		$modulesModel->createTable();

		$modulesModel = new SpItemPricing();
		$modulesModel->createTable();
		
		$modulesModel = new SpItem();
		$modulesModel->createTable();
		
		$modulesModel = new SpProject();
		$modulesModel->createTable();
		
		$modulesModel = new SpResponsible();
		$modulesModel->createTable();
		$modulesModel->createDefaultResponsible();
		
		$modulesModel = new SpBill();
		$modulesModel->createTable();
		
		$message = 'success';
		return $message;
	}
}

