<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sheet/Model/ShInstall.php';


class ControllerSheetconfig extends ControllerSecureNav {

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
		
		$status = $ModulesManagerModel->getDataMenusUserType("sheet");
		$menuStatus = array("name" => "sheet", "status" => $status);
		
		
		// install database
		$installquery = $this->request->getParameterNoException ( "installquery" );
		if ($installquery == "yes"){
			try{
				$installModel = new ShInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
				$installError =  $e->getMessage();
				$installSuccess = "<b>Success:</b> the database have been successfully installed";
				$this->generateView ( array ('navBar' => $navBar,
						'installError' => $installError,
						'menuStatus' => $menuStatus
				) );
				return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar,
					'installSuccess' => $installSuccess,
					'menuStatus' => $menuStatus
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menuStatus = $this->request->getParameterNoException("sheetmenu");
				
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("sheet", "sheet/index", $menuStatus, "glyphicon glyphicon-duplicate");
				
			$status = $ModulesManagerModel->getDataMenusUserType("sheet");
			$menuStatus = array("name" => "sheet", "status" => $status);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menuStatus' => $menuStatus
			) );
			return;		
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'menuStatus' => $menuStatus
		) );
	}
}