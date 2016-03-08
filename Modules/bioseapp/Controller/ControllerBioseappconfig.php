<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/bioseapp/Model/BiInstall.php';

/**
 * Configuation controller for the template module
 * @author sprigent
 */
class ControllerBioseappconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("biose");
		$menus[0] = array("name" => "biose", "status" => $status);

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new BiInstall();
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
			$ModulesManagerModel->setDataMenu("biose", "bioseapp", $menusStatus[0], "glyphicon glyphicon-plus");
			
			$status = $ModulesManagerModel->getDataMenusUserType("biose");
			$menus[0] = array("name" => "biose", "status" => $status);
			
			
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