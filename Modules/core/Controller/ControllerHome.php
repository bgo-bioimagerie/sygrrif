<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

/**
 * 
 * @author sprigent
 * Controller for the home page
 */
class ControllerHome extends ControllerSecureNav {

	/**
	 * Constructor
	 */
	public function __construct() {
            parent::__construct();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		$navBar = $this->navBar();
		
		$toolMenu = $this->getToolsMenu();
		$toolAdmin = $this->getAdminMenu();
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'toolMenu' => $toolMenu, 
				'toolAdmin' => $toolAdmin
		) );
	}
	
}

