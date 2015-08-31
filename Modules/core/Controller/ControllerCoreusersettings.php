<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/UserSettings.php';

/**
 * 
 * @author sprigent
 * Edit the application settings	
 */
class ControllerCoreusersettings extends ControllerSecureNav {

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
	
	/**
	 * Edit the application settings
	 */
	public function editsettings(){
		$language = $this->request->getParameter("language");
	
		$user_id = $this->request->getSession()->getAttribut("id_user");
	
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "language", $language);
	
		$userSettingsModel->updateSessionSettingVariable();
	
		$this->redirect("coreusersettings");
	}
	
	/**
	 * Edit the home page URL
	 */
	public function edithomepage(){
		$homePage = $this->request->getParameter("homepage");
		
		$user_id = $this->request->getSession()->getAttribut("id_user");
		
		$userSettingsModel = new UserSettings();
		$userSettingsModel->setSettings($user_id, "homepage", $homePage);
		
		$userSettingsModel->updateSessionSettingVariable();
		
		$this->redirect("coreusersettings");
	}
	
}