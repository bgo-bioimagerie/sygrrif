<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/mailer/Model/MailerTranslator.php';


class ControllerMailerconfig extends ControllerSecureNav {

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
		
		$status = $ModulesManagerModel->getDataMenusUserType("email");
		$menuStatus = array("name" => "email", "status" => $status);
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menuStatus = $this->request->getParameterNoException("emailmenu");
				
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("email", "mailer/index", $menuStatus, "glyphicon glyphicon-envelope");
				
			$status = $ModulesManagerModel->getDataMenusUserType("email");
			$menuStatus = array("name" => "email", "status" => $status);
			
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