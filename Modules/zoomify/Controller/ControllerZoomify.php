<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/zoomify/Model/ZoTranslator.php';
require_once 'Modules/zoomify/Model/ZoUploader.php';
require_once 'Modules/zoomify/Model/ZoDirectories.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreConfig.php';

class ControllerZoomify extends ControllerSecureNav {

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

		
		// default
		$this->generateView ( array ('navBar' => $navBar
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
		$dirname = $this->request->getParameter("dir");
		
		// remove some caracters for security
		$filename = str_replace ( "./" , "" , $filename );
		$filename = str_replace ( "../" , "" , $filename );
		$filename = str_replace ( "/" , "" , $filename );
		
		$dirname = str_replace ( "./" , "" , $dirname );
		$dirname = str_replace ( "../" , "" , $dirname );
		$dirname = str_replace ( "/" , "" , $dirname );
		
		// get the user login
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		$zoomifyDir = Configuration::get("zoomifyDir");
		$fileUrl = $zoomifyDir . $dirname . "/" . $userlogin . "/" . basename($filename);
		
		// download
		$modelFiles = new StUploader();
		$modelFiles->outputFile($fileUrl, $filename);
		
	}
}