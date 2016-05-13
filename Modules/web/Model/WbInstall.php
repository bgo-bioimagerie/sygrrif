<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/web/Model/WbMenu.php';
require_once 'Modules/web/Model/WbCarousel.php';
require_once 'Modules/web/Model/WbFeature.php';
require_once 'Modules/web/Model/WbSubMenu.php';
require_once 'Modules/web/Model/WbArticle.php';
require_once 'Modules/web/Model/WbContact.php';
require_once 'Modules/web/Model/WbTeam.php';
require_once 'Modules/web/Model/WbArticleList.php';


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
                
                $modelc = new WbContact();
		$modelc->createTable();
                
                $modelt = new WbTeam();
		$modelt->createTable();
                
                $modelal = new WbArticleList();
		$modelal->createTable();
                
                
		$message = 'success';
		return $message;
	}
}

