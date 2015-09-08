<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/zoomify/Model/ZoInstall.php';
require_once 'Modules/zoomify/Model/ZoTranslator.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/zoomify/Model/ZoUploader.php';



class ControllerZoomifyconfig extends ControllerSecureNav {

	public function __construct() {

	}

	/**
	 * (non-PHPdoc)
	 * Show the config index page
	 * 
	 * @see Controller::index()
	 */
	public function index() {

		// nav bar
		$navBar = $this->navBar();

		// activated menus list
		$ModulesManagerModel = new ModulesManager();
		
		$status = $ModulesManagerModel->getDataMenusUserType("zoomify");
		$menuStatus = array("name" => "zoomify", "status" => $status);
		
		$directories = array();
		if ($menuStatus["status"] > 0){
			$modelDir = new StDirectories();
			$directories = $modelDir->getDirectories();
		}
		//print_r($directories);
		
		// install database
		$installquery = $this->request->getParameterNoException ( "installquery" );
		if ($installquery == "yes"){
			try{
				$installModel = new StInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
				$installError =  $e->getMessage();
				$installSuccess = "<b>Success:</b> the database have been successfully installed";
				$this->generateView ( array ('navBar' => $navBar,
						'installError' => $installError,
						'menuStatus' => $menuStatus,
						'directories' => $directories
				) );
				return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar,
					'installSuccess' => $installSuccess,
					'menuStatus' => $menuStatus,
					'directories' => $directories
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menuStatus = $this->request->getParameterNoException("zoomifymenu");
				
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("zoomify", "zoomify/index", $menuStatus, "glyphicon glyphicon-picture");
				
			$status = $ModulesManagerModel->getDataMenusUserType("zoomify");
			$menuStatus = array("name" => "zoomify", "status" => $status);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menuStatus' => $menuStatus,
					'directories' => $directories
			) );
			return;		
		}
		
		// set directories
		$setdirectoriesquery = $this->request->getParameterNoException ( "setdirectoriesquery");
		if ($setdirectoriesquery == "yes"){
			$zoomifyDirectoriesNames = $this->request->getParameterNoException("zoomifydirectoriesnames");
			$zoomifyDirectoriesIds = $this->request->getParameterNoException("zoomifydirectoriesids");
			
			$modelDir = new StDirectories();
			$modelDir->removeAll();
			for($i=0 ; $i < count($zoomifyDirectoriesNames) ; $i++){
				
				//echo " ids[] = " . $zoomifyDirectoriesIds[$i] . ", ids[] = " . $zoomifyDirectoriesNames[$i]; 
				
				$modelDir->setDir($zoomifyDirectoriesIds[$i], $zoomifyDirectoriesNames[$i]);
			}
			
			$directories = $modelDir->getDirectories();
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'menuStatus' => $menuStatus,
									 'directories' => $directories
		) );
	}
}