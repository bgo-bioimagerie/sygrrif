<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/UserSettings.php';

class ControllerCoreusersettings extends ControllerSecureNav {

	public function __construct() {
	}

	// View the user settings form -> language selection
	public function index() {
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$language = $userSettingsModel->getUserSetting($user_id, "language");
		$homePage = $userSettingsModel->getUserSetting($user_id, "homePage"); 
		if ($homePage == ""){
			$homePage = "Home";
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'language' => $language,
				'homePage' => $homePage
		) );
	}
	
	public function editsettings(){
		$language = $this->request->getParameter("language");
	
		$user_id = $this->request->getSession()->getAttribut("id_user");
	
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "language", $language);
	
		$userSettingsModel->updateSessionSettingVariable();
	
		$this->redirect("coreusersettings");
	}
	
	public function edithomepage(){
		$homePage = $this->request->getParameter("homepage");
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "homepage", $homePage);
		
		$userSettingsModel->updateSessionSettingVariable();
		
		$this->redirect("coreusersettings");
	}
	
}