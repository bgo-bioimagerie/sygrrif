<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/storage/Model/StInstall.php';
require_once 'Modules/storage/Model/StTranslator.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/storage/Model/StUploader.php';



class ControllerStorageconfig extends ControllerSecureNav {

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
		
		$status = $ModulesManagerModel->getDataMenusUserType("storage");
		$menuStatus = array("name" => "storage", "status" => $status);
		
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
			$menuStatus = $this->request->getParameterNoException("storagemenu");
				
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("storage", "storage/index", $menuStatus, "glyphicon glyphicon-hdd");
				
			$status = $ModulesManagerModel->getDataMenusUserType("storage");
			$menuStatus = array("name" => "storage", "status" => $status);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menuStatus' => $menuStatus,
					'directories' => $directories
			) );
			return;		
		}
		
		// set directories
		$setdirectoriesquery = $this->request->getParameterNoException ( "setdirectoriesquery");
		if ($setdirectoriesquery == "yes"){
			$storageDirectoriesNames = $this->request->getParameterNoException("storagedirectoriesnames");
			$storageDirectoriesIds = $this->request->getParameterNoException("storagedirectoriesids");
			
			$modelDir = new StDirectories();
			$modelDir->removeAll();
			for($i=0 ; $i < count($storageDirectoriesNames) ; $i++){
				
				//echo " ids[] = " . $storageDirectoriesIds[$i] . ", ids[] = " . $storageDirectoriesNames[$i]; 
				
				$modelDir->setDir($storageDirectoriesIds[$i], $storageDirectoriesNames[$i]);
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