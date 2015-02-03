<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/UserSettings.php';

class ControllerSettings extends ControllerSecureNav {

	public function __construct() {
	}

	// View the user settings form -> language selection
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