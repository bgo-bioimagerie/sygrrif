<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';
require_once 'Modules/supplies/Model/SuItem.php';
require_once 'Modules/supplies/Model/SuEntry.php';
require_once 'Modules/supplies/Model/SuBill.php';

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
		
		$modulesModel1 = new SuItemPricing();
		$modulesModel1->createTable();
		
		$modulesModel2 = new SuItem();
		$modulesModel2->createTable();
		
		$modulesModel3 = new SuEntry();
		$modulesModel3->createTable();
		
		$modulesModel5 = new SuBill();
		$modulesModel5->createTable();
		
		$message = 'success';
		return $message;
	}
}

