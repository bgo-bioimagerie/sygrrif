<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

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

		$this->generateView ( array (
				'navBar' => $navBar,
				'calendarDefaultView' => $calendarDefaultView
		) );
	}
	
	/**
	 * Query to edit the calendar user setting 
	 */
	public function editcalendarsettings(){
		$calendarDefaultView = $this->request->getParameter("calendarDefaultView");
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "calendarDefaultView", $calendarDefaultView);
		
		$userSettingsModel->updateSessionSettingVariable();
		
		$this->redirect("sygrrifusersettings");
	}
	
}