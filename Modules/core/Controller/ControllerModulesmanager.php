<?php
require_once 'Framework/Controller.php';
require_once 'Framework/Configuration.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerModulesmanager extends ControllerSecureNav {
		
	public function __construct() {

	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		// get the modules list
		$modules = Configuration::get('modules');
		$mods = array();
		$count = -1;
		for ($i = 0 ; $i < count($modules) ; ++$i){
			
			$viewfolder = ucfirst ( strtolower ( $modules[$i] ) ) . "config";
			$abstractFile = "Modules/" . $modules[$i] . "/View/".$viewfolder."/abstract.php";
			if (file_exists($abstractFile)){
				$count++;
				// name
				$mods[$count]['name'] = $modules[$i];
				// get abstract html text
				$mods[$count]['abstract'] = $abstractFile;
				// construct action
				$action = $modules[$i] . "config";
				$mods[$count]['action'] = $action;
			}
		}
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'modules' => $mods 
		) );
	}

}