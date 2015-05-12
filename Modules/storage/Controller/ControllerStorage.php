<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/storage/Model/StTranslator.php';
require_once 'Modules/storage/Model/StUserQuota.php';
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
		
		
		$modelQuotas = new StUserQuota();
		$modelFiles = new StUploader();
		
		if (!$modelQuotas->isQuota($idUser)){
			
			$moduleCoreConfig = new CoreConfig();
			$defaultQuota = $moduleCoreConfig->getParam("storage_quota");
			
			$modelQuotas->setQuota($idUser, $defaultQuota);
			$modelFiles->initializeDirectory($userlogin);
			
		}
		
		// get user files 
		$files = $modelFiles->getFiles($userlogin);
		
		// get quotas informations
		$userQuotas = $modelQuotas->getQuota($idUser);
		$userUsage = $modelFiles->getUsage($userlogin);
		$userUsage = $modelFiles->formatFileSize($userUsage);
		
		// default
		$this->generateView ( array ('navBar' => $navBar, "files" => $files, "userlogin" => $userlogin, "message" => $message,
				"userQuotas" => $userQuotas["quota"], "userUsage" => $userUsage, "menu" => $menu
		), "index" );
	}
	
	public function deletefile(){
		
		$fileName = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$fileName = $this->request->getParameter("actionid");
		}
		
		$fileName = str_replace("__--__", ".", $fileName);
		$fileName = str_replace("__---__", " ", $fileName);
		$fileName = str_replace("__----__", "/", $fileName);
		
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		$modelFiles = new StUploader();
		$modelFiles->deleteFile($fileName);
		
		$this->redirect("storage/index");
	}
	
	public function download(){
		
		// get the user language
		$lang = "En";
		if (isset ( $_SESSION ["user_settings"] ["language"] )) {
			$lang = $_SESSION ["user_settings"] ["language"];
		}
		
		// get form posts
		$localurl = $this->request->getParameter("localurl");
		$filename = $this->request->getParameter("filename");
		
		// get the user login
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		// parse the files names
		$filename = str_replace("__--__", ".", $filename);
		$filename = str_replace("__---__", " ", $filename);
		$filename = str_replace("__----__", "/", $filename);
		$localurl = str_replace("\\", "/" , $localurl) . "/" . basename($filename);
		$fileName = "./" . $userlogin ."/".basename($filename);
		
		// refuse to download if the quotas is over
		$modelQuotas = new StUserQuota();
		$userQuotas = $modelQuotas->getQuota($idUser); // in GB
		$modelUploader = new StUploader();
		$usage = $modelUploader->getUsage($userlogin);
		$usage = $usage/1000000000;  
		
		if ($usage >= $userQuotas){
			$this->index( StTranslator::QuotasHoverMessage($lang) . $localurl);
			return;
		}
		
		// download
		$modelFiles = new StUploader();
		$modelFiles->downloadFile($localurl, $fileName);
		
		
		// view
		$this->index( StTranslator::DownloadMessage($lang) . $localurl);
		return;
	}
	
	public function upload(){
		
		// nav bar
		$navBar = $this->navBar();
		$this->generateView ( array ('navBar' => $navBar) );
	}
	
	public function uploadfile(){
		
		$filename = $this->request->getParameter("filename");
		
		//echo "filename = " . $filename . "<br/>";
		
		$filename = str_replace("\\", "/", $filename);
		//echo "filename = " . $filename . "<br/>";
		
		// get the user login
		$idUser = $_SESSION["id_user"];
		$modelUser = new User();
		$userlogin = $modelUser->userLogin($idUser);
		
		// upload the file
		$modelFiles = new StUploader();
		$addressServer = "./" . $userlogin ."/".basename($filename);
		$modelFiles->uploadFile($filename, $addressServer);	

		$this->redirect("storage/index");
	}
	
	public function usersquotas(){
		
		if ($_SESSION["user_status"] <= 2){
			return "permission denied";
		}
		
		// get the user quotas
		$modelquotas = new StUserQuota();
		$usersquotas = $modelquotas->getUsersQuotas();
		
		// nav bar
		$navBar = $this->navBar();
		$this->generateView ( array ('navBar' => $navBar, "usersquotas" => $usersquotas) );
	}
	
	public function editquota(){
		
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		// get the user quotas
		$modelquotas = new StUserQuota();
		$userquota = $modelquotas->getUserQuota($id);
		
		print_r($userquota);
		
		// nav bar
		$navBar = $this->navBar();
		$this->generateView ( array ('navBar' => $navBar, "userquota" => $userquota[0]) );
	}
	
	public function editquotaquery(){
		
		$id = $this->request->getParameter("id");
		$quota = $this->request->getParameter("quota");
		
		// get the user quotas
		$modelquotas = new StUserQuota();
		$modelquotas->setQuota($id, $quota);
		
		$this->redirect("storage/usersquotas");
		
	}
}