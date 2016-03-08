<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreProject.php';
require_once 'Modules/core/Model/CoreResponsible.php';
require_once 'Modules/core/Model/CoreStatus.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/core/Model/CoreBelonging.php';

/**
 * Class defining methods to install and initialize the core database
 *
 * @author Sylvain Prigent
 */
class CoreInitDatabase extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new ModulesManager();
		$modulesModel->createTable();
		$modulesModel->addCoreDefaultMenus();
		
		$userModel = new CoreUser();
		$pdo = $userModel->createTable();
		$pdo = $userModel->createDefaultUser();
		$pdo = $userModel->createDefaultAdmin();
		
		$unitModel = new CoreUnit();
		$pdo = $unitModel->createTable();
		$pdo = $unitModel->createDefaultUnit();
		
		$respModel = new CoreResponsible();
		$pdo = $respModel->createTable();
		$pdo = $respModel->createDefaultResponsible();
		
		$statusModel = new CoreStatus();
		$pdo = $statusModel->createTable();
		$pdo = $statusModel->createDefaultStatus();
		
		$configModel = new CoreConfig();
		$configModel->createTable();
		$configModel->createDefaultConfig();
		
		$projectModel = new CoreProject();
		$projectModel->createTable();
		
		$UserSettingsModel = new UserSettings();
		$UserSettingsModel->createTable();
		
		$model = new CoreBelonging();
		$model->createTable();
		$model->createDefault();
		
		
		if (!file_exists('data/core')) {
    		mkdir('data/core', 0777, true);
		}
		
		$message = 'success';
		return $message;
	}
}

