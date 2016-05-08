<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';

require_once 'Modules/web/Model/WbInstall.php';

/**
 * Configuation controller for the web module
 * @author sprigent
 */
class ControllerWebconfig extends ControllerSecureNav {

	public function __construct() {
            parent::__construct();
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
		$status = $ModulesManagerModel->getDataMenusUserType("web");
		$menus[0] = array("name" => "web", "status" => $status);

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new WbInstall();
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
			$ModulesManagerModel->setDataMenu("web", "web", $menusStatus[0], "glyphicon glyphicon-globe");
			
			$status = $ModulesManagerModel->getDataMenusUserType("web");
			$menus[0] = array("name" => "web", "status" => $status);
                        
                        $modelConfig = new CoreConfig();
                        if ($status > 0 ){
                            $modelConfig->setParam("home_url", "wbhome");
                        }
                        else{
                            $modelConfig->setParam("home_url", "");
                        }
			
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