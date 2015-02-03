<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyStatsUser.php';

class ControllerSygrrifstatsusers extends ControllerSecureNav {

	public function __construct() {
	}

	public function index(){
		
	}
	
	public function statusers() {
		
		// get the resource list
		$resourceModel = new SyResourcesCategory();
		$resourcesCategories = $resourceModel->getResourcesCategories("name");

		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'resourcesCategories' => $resourcesCategories
		) );
	}
	
	public function authorizeduserquery(){
		
		// get the selected resource id
		$resource_id = $this->request->getParameter("resource_id");
		
		// query
		$statUserModel = new SyStatsUser();
		$statUserModel->authorizedUsers($resource_id);
		
		return;
	}
	
	public function userquery(){
		// get the user type id
		$user_type = $this->request->getParameter("user_type");
		
		/// @todo implement this query
		$this->redirect("sygrrifstatsusers", "statusers" );
	}
}