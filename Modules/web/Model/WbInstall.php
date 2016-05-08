<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/web/Model/WbMenu.php';
require_once 'Modules/web/Model/WbCarousel.php';
require_once 'Modules/web/Model/WbFeature.php';
require_once 'Modules/web/Model/WbSubMenu.php';
require_once 'Modules/web/Model/WbArticle.php';


/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class WbInstall extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$modulesModel = new WbMenu();
		$modulesModel->createTable();
                
                $modelCarousel = new WbCarousel();
		$modelCarousel->createTable();
                $modelCarousel->createDefault();
                
                $modelFeature = new WbFeature();
		$modelFeature->createTable();
                $modelFeature->createDefault();
                
                $modelsm = new WbSubMenu();
		$modelsm->createTable();
                
                $modela = new WbArticle();
		$modela->createTable();
                
		$message = 'success';
		return $message;
	}
}

