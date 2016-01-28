<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/catalog/Model/CaCategory.php';
require_once 'Modules/catalog/Model/CaEntry.php';
require_once 'Modules/catalog/Model/CaAntibodyEntry.php';


/**
 * Class defining methods to install and initialize the catalog database
 *
 * @author Sylvain Prigent
 */
class CaInstall extends Model {

	/**
	 * Create the core database
	 *
	 * @return message if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel1 = new CaCategory();
		$modulesModel1->createTable();
		
		$modulesModel2 = new CaEntry();
		$modulesModel2->createTable();
                
                $modelAntibody = new CaAntibodyEntry();
                $modelAntibody->createTable();
		
		$message = 'success';
		return $message;
	}
}

