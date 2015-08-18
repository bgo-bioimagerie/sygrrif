<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/storage/Model/StTranslator.php';
require_once 'Modules/storage/Model/StUploader.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreConfig.php';

class ControllerStorage extends ControllerSecureNav {

	public function __construct() {

	}

	protected function viewMenu(){
		
		// get the user status
		$userStatus = $_SESSION["user_status"];
		
		// menus
		$menu = false;
		if ($userStatus > 2){
			$menu = true;
		}
		return $menu;
	}
	
	/**
	 * (non-PHPdoc)
	 * Show the config index page
	 * 
	 * @see Controller::index()
	 */
	public function index($message = "") {

		// nav bar
		$navBar = $this->navBar();
		$menu = $this->viewMenu();
		
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		$modelFiles = new StUploader();
		
		// get user files 
		$storageDir = Configuration::get("storageDir");
		$files = $modelFiles->getFiles($storageDir . $userlogin);
		
		$userUsage = 0;
		if (count($files) == 0){
			$lang = "En";
			if (isset ( $_SESSION ["user_settings"] ["language"] )) {
				$lang = $_SESSION ["user_settings"] ["language"];
			}
			$message = StTranslator::noUserDirMessage($lang, $userlogin);
		}
		else{
			// get quotas informations
			$userUsage = $modelFiles->getUsage($storageDir . $userlogin);
			$userUsage = $modelFiles->formatFileSize($userUsage);
		}
		// default
		$this->generateView ( array ('navBar' => $navBar, "files" => $files, "userlogin" => $userlogin, "message" => $message,
				"userUsage" => $userUsage, "menu" => $menu
		), "index" );
	}
		
	public function download(){
		
		// get the user language
		$lang = "En";
		if (isset ( $_SESSION ["user_settings"] ["language"] )) {
			$lang = $_SESSION ["user_settings"] ["language"];
		}
		
		// get form posts
		$filename = $this->request->getParameter("filename");
		
		// get the user login
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		$storageDir = Configuration::get("storageDir");
		$fileUrl = $storageDir . $userlogin . "/" . basename($filename);
		
		// download
		$modelFiles = new StUploader();
		$modelFiles->outputFile($fileUrl, $filename);
		
	}
}