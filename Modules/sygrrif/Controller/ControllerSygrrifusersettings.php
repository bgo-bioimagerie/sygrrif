<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';


class ControllerSygrrifusersettings extends ControllerSecureNav {

	public function __construct() {
	}

	// View the user settings form
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
	
	public function editcalendarsettings(){
		$calendarDefaultView = $this->request->getParameter("calendarDefaultView");
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "calendarDefaultView", $calendarDefaultView);
		
		$userSettingsModel->updateSessionSettingVariable();
		
		$this->redirect("sygrrifusersettings");
	}
	
}