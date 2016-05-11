<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/agenda/Model/AgInstall.php';

/**
 * Configuation controller for the agenda module
 * @author sprigent
 */
class ControllerAgendaconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("agenda");
		$menus[0] = array("name" => "agenda", "status" => $status);
                $status1 = $ModulesManagerModel->getDataMenusUserType("agendaadmin");
		$menus[1] = array("name" => "agendaadmin", "status" => $status1);

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new AgInstall();
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
			$ModulesManagerModel->setDataMenu("agenda", "agenda", $menusStatus[0], "glyphicon glyphicon-calendar");
			$ModulesManagerModel->setDataMenu("agendaadmin", "agendaadmin", $menusStatus[1], "glyphicon glyphicon-calendar");
			
			$status = $ModulesManagerModel->getDataMenusUserType("agenda");
			$menus[0] = array("name" => "agenda", "status" => $status);
			
                        $status1 = $ModulesManagerModel->getDataMenusUserType("agendaadmin");
			$menus[1] = array("name" => "agendaadmin", "status" => $status1);
			
			
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