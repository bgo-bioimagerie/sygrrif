<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/supplies/Model/SuInitDatabase.php';


class ControllerSuppliesconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("supplies");
		$menus[0] = array("name" => "supplies", "status" => $status);

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new SuInitDatabase();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'menus' => $menus	
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'menus' => $menus
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menusStatus = $this->request->getParameterNoException("menus");
			
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("supplies", "supplies", $menusStatus[0], "glyphicon-shopping-cart");
			
			$status = $ModulesManagerModel->getDataMenusUserType("supplies");
			$menus[0] = array("name" => "supplies", "status" => $status);
			
			
			$this->generateView ( array ('navBar' => $navBar,
				                     'menus' => $menus
									 	
			) );
			return;
			
		}
		
				
		// default
		$this->generateView ( array ('navBar' => $navBar,
				'menus' => $menus
		) );
	}
}