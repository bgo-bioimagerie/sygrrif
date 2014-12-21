<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/core/Model/Status.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Class defining methods to install and initialize the core database
 *
 * @author Sylvain Prigent
 */
class InitDatabase extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new ModulesManager();
		$modulesModel->createTable();
		$modulesModel->addCoreDefaultMenus();
		
		$userModel = new User();
		$pdo = $userModel->createTable();
		$pdo = $userModel->createDefaultUser();
		$pdo = $userModel->createDefaultAdmin();
		
		$unitModel = new Unit();
		$pdo = $unitModel->createTable();
		$pdo = $unitModel->createDefaultUnit();
		
		$respModel = new Responsible();
		$pdo = $respModel->createTable();
		$pdo = $respModel->createDefaultResponsible();
		
		$statusModel = new Status();
		$pdo = $statusModel->createTable();
		$pdo = $statusModel->createDefaultStatus();
		
		$configModel = new CoreConfig();
		$configModel->createTable();
		$configModel->createDefaultConfig();
		
		$message = 'success';
		return $message;
	}
}

