<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/UserSettings.php';

/**
 * Edit the application settings
 * 
 * @author sprigent
 *
 */
class ControllerSettings extends ControllerSecureNav {

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {

		
		// get the available modules settings
		$modules = Configuration::get("modules");
		$modulesControllers = array();
		$i = -1;
		foreach ($modules as $module){
		
			$controllerName = $module . "usersettings";
			$controllerName = ucfirst ( strtolower ( $controllerName ) );
		
			$fileController = 'Modules/' . $module . "/Controller/Controller" . $controllerName . ".php";
			if (file_exists($fileController)){
				$i++;
				$modulesControllers[$i]["module"] = $module;
				$modulesControllers[$i]["controller"] = $controllerName;
			}
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'modulesControllers' => $modulesControllers
		) );
	}
}