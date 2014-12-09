<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';


class ControllerSygrrifconfig extends ControllerSecureNav {

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
		$isSygrrifMenu = $ModulesManagerModel->isDataMenu("sygrrif");
		
		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new SyInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'isSygrrifMenu' => $isSygrrifMenu
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'isSygrrifMenu' => $isSygrrifMenu
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$ModulesManagerModel = new ModulesManager();
			
			// sygrrif data menu
			$sygrrifDataMenu = $this->request->getParameterNoException ("sygrrifdatamenu");
			
			if ($sygrrifDataMenu != ""){
				if (!$ModulesManagerModel->isDataMenu("sygrrif")){
					$ModulesManagerModel->addDataMenu("sygrrif", "sygrrif", 1);
					$isSygrrifMenu = true;
				}
				
				$this->generateView ( array ('navBar' => $navBar,
						                     'isSygrrifMenu' => $isSygrrifMenu) );
				return;
			}
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu
		) );
	}
}