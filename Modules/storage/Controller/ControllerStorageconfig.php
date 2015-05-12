<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/storage/Model/StInstall.php';
require_once 'Modules/storage/Model/StTranslator.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/storage/Model/StUploader.php';



class ControllerStorageconfig extends ControllerSecureNav {

	public function __construct() {

	}

	/**
	 * (non-PHPdoc)
	 * Show the config index page
	 * 
	 * @see Controller::index()
	 */
	public function index() {

		// nav bar
		$navBar = $this->navBar();

		// activated menus list
		$ModulesManagerModel = new ModulesManager();
		
		$status = $ModulesManagerModel->getDataMenusUserType("storage");
		$menuStatus = array("name" => "storage", "status" => $status);
		
		$moduleCoreConfig = new CoreConfig();
		$quota = $moduleCoreConfig->getParam("storage_quota");
		
		$modelUploader = new StUploader();
		$ftp = $modelUploader->getFtpSettings();
		
		
		// install database
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new StInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
				$installError =  $e->getMessage();
				$installSuccess = "<b>Success:</b> the database have been successfully installed";
				$this->generateView ( array ('navBar' => $navBar,
						'installError' => $installError,
						'menuStatus' => $menuStatus,
						'quota' => $quota,
						'ftp' => $ftp
				) );
				return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar,
					'installSuccess' => $installSuccess,
					'menuStatus' => $menuStatus,
					'quota' => $quota,
					'ftp' => $ftp
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menuStatus = $this->request->getParameterNoException("storagemenu");
				
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("storage", "storage/index", $menuStatus, "glyphicon glyphicon-hdd");
				
			$status = $ModulesManagerModel->getDataMenusUserType("storage");
			$menuStatus = array("name" => "storage", "status" => $status);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menuStatus' => $menuStatus,
					'quota' => $quota,
					'ftp' => $ftp
						
			) );
			return;
				
		}
		
		// set default quta
		$setquotaquery = $this->request->getParameterNoException("setquotaquery");
		if ($setquotaquery == "yes"){
			
			$quota = $this->request->getParameterNoException("quota");
			
			$moduleCoreConfig = new CoreConfig();
			$moduleCoreConfig->setParam("storage_quota", $quota);
			$quota = $moduleCoreConfig->getParam("storage_quota");
		}
		
		// set default quta
		$setftpquery = $this->request->getParameterNoException("setftpquery");
		if ($setftpquery == "yes"){
				
			$host = $this->request->getParameterNoException("host");
			$port = $this->request->getParameterNoException("port");
			$login = $this->request->getParameterNoException("login");
			$pwd = $this->request->getParameterNoException("pwd");
				
			$modelUploader->setFtpSettings($host, $port, $login, $pwd);
			$ftp = $modelUploader->getFtpSettings();
			
		}
		
	
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'menuStatus' => $menuStatus,
				                     'quota' => $quota,
									 'ftp' => $ftp
		) );
	}
}