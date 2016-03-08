<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/catalog/Model/CaInstall.php';

/**
 * Configuation controller for the template module
 * @author sprigent
 */
class ControllerCatalogconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("catalog");
		$menus[0] = array("name" => "catalog", "status" => $status);
		$status1 = $ModulesManagerModel->getDataMenusUserType("catalog manager");
		$menus[1] = array("name" => "catalogadmin", "status" => $status1);
                
                $modelConfig = new CoreConfig();
                $antibody_plugin = $modelConfig->getParam("ca_use_antibodies");
                
                

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new CaInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'menus' => $menus,
                                                             'antibody_plugin' => $antibody_plugin
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'menus' => $menus,
                                                             'antibody_plugin' => $antibody_plugin
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menusStatus = $this->request->getParameterNoException("menus");
			
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("catalog", "catalog", $menusStatus[0], "glyphicon glyphicon-th-list");
			$ModulesManagerModel->setDataMenu("catalog manager", "catalogadmin", $menusStatus[1], "glyphicon glyphicon-th-list");
			
			$status1 = $ModulesManagerModel->getDataMenusUserType("catalog");
			$menus[0] = array("name" => "catalog", "status" => $status1);
			$status2 = $ModulesManagerModel->getDataMenusUserType("catalog manager");
			$menus[1] = array("name" => "catalog manager", "status" => $status2);	
			
			$this->generateView ( array ('navBar' => $navBar,
				                     'menus' => $menus,
                                                     'antibody_plugin' => $antibody_plugin
									 	
			) );
			return;
		}
		
                // plugins activation
		$setpluginsquery = $this->request->getParameterNoException ( "setpluginsquery");
		if ($setpluginsquery == "yes"){
			$antibody_pluginR = $this->request->getParameterNoException("antibody_plugin");
                        $modelConfig->setParam("ca_use_antibodies", $antibody_pluginR);
                        $antibody_plugin = $modelConfig->getParam("ca_use_antibodies");
                }
                        
                 
		// default
		$this->generateView ( array ('navBar' => $navBar,
				'menus' => $menus,
                                'antibody_plugin' => $antibody_plugin
		) );
	}
}