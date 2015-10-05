<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyStatsUser.php';

/**
 * Controller to generate statistics on the users
 * 
 * @author sprigent
 *
 */
class ControllerSygrrifstatsusers extends ControllerSecureNav {

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index(){
		
	}
	
	/**
	 * Form to export the list of authorized user per resource category
	 */
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
	
	/**
	 * Query to export the list of authorized user per resource category
	 */
	public function authorizeduserquery(){
		
		// get the selected resource id
		$resource_id = $this->request->getParameter("resource_id");
		$email = $this->request->getParameterNoException("email");
		
		// query
		$statUserModel = new SyStatsUser();
		if($email != ""){
			header_remove();
			ob_clean();
			$statUserModel->authorizedUsersMail($resource_id);
		}
		else{
			header_remove();
			ob_clean();
			$statUserModel->authorizedUsers($resource_id);
		}	
		
		return;
	}
	
	/**
	 * Not implemented method
	 */
	public function userquery(){
		// get the user type id
		$user_type = $this->request->getParameter("user_type");
		
		/// @todo implement this query
		$this->redirect("sygrrifstatsusers", "statusers" );
	}
}