<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/LdapConfiguration.php';

/**
 * 
 * @author sprigent
 * 
 * Config the home page informations
 */
class ControllerHomeconfig extends ControllerSecureNav {

	/**
	 * Constructor
	 */
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
		
		$modelSettings = new CoreConfig();
		$logo = $modelSettings->getParam("logo");	
		$home_title = $modelSettings->getParam("home_title");
		$home_message = $modelSettings->getParam("home_message");
		
		
		$this->generateView ( array ('navBar' => $navBar,
									 'logo' => $logo,
									 'home_title' => $home_title,
									 'home_message' => $home_message 
		) );
	}

	/**
	 * Edit the home settings
	 */
	public function editquery(){
		
		// get the post parameters
		$logo = $this->request->getParameter ("logo");
		$home_title = $this->request->getParameter ("home_title");
		$home_message = $this->request->getParameter ("home_message");
		
		$modelSettings = new CoreConfig();
		$modelSettings->setParam("logo", $logo);
		$modelSettings->setParam("home_title", $home_title);
		$modelSettings->setParam("home_message", $home_message);

		$this->redirect("coreconfig");
	}
}