<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';

/**
 * Controller to edit user settings
 * 
 * @author sprigent
 *
 */
class ControllerSygrrifusersettings extends ControllerSecureNav {

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
		
		$navBar = $this->navBar();
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		$userSettingsModel = new UserSettings();
		$calendarDefaultView = $userSettingsModel->getUserSetting($user_id, "calendarDefaultView");
		$calendarDefaultResource = $userSettingsModel->getUserSetting($user_id, "calendarDefaultResource");
		
		$_SESSION["user_status"];
		// get the resources the user can see
		$modelArea = new SyArea();
		if ($_SESSION["user_status"] < 3){
			$areas = $modelArea->getUnrestrictedAreasIDName();
		}
		else{
			$areas = $modelArea->getAreasIDName();
		}
		
		$modelResource = new SyResource();
		foreach($areas as $area){
			$resources[] = $modelResource->resourceIDNameForArea($area["id"]);
		}

		$this->generateView ( array (
				'navBar' => $navBar,
				'calendarDefaultView' => $calendarDefaultView,
				'calendarDefaultResource' => $calendarDefaultResource,
				'resources' => $resources
		) );
	}
	
	/**
	 * Query to edit the calendar user setting 
	 */
	public function editcalendarsettings(){
		$calendarDefaultView = $this->request->getParameter("calendarDefaultView");
		$calendarDefaultResourceId = $this->request->getParameter("calendarDefaultResource");
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "calendarDefaultView", $calendarDefaultView);
		$userSettingsModel->setSettings($user_id, "calendarDefaultResource", $calendarDefaultResourceId);
		
		$userSettingsModel->updateSessionSettingVariable();
		
		$this->redirect("sygrrifusersettings");
	}
	
}