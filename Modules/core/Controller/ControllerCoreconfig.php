<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/InitDatabase.php';
require_once 'Modules/core/Model/CoreConfig.php';


class ControllerCoreconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("users/institutions");
		$menus[0] = array("name" => "users/institutions", "status" => $status);
		
		// user setting
		$modelCoreConfig = new CoreConfig();
		$activeUserSetting = $modelCoreConfig->getParam('user_desactivate');
		
		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new InitDatabase();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'menus' => $menus,
    										 'activeUserSetting' => $activeUserSetting 	
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'menus' => $menus,
										 'activeUserSetting' => $activeUserSetting
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menusStatus = $this->request->getParameterNoException("menus");
			
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("users/institutions", "users", $menusStatus[0], "glyphicon-user");
				
			
			$status = $ModulesManagerModel->getDataMenusUserType("users/institutions");
			$menus[0] = array("name" => "users/institutions", "status" => $status);
			
			
			$this->generateView ( array ('navBar' => $navBar,
				                     'menus' => $menus,
									 'activeUserSetting' => $activeUserSetting
									 	
			) );
			return;
			
		}
		
		// active user
		$setactivuserquery = $this->request->getParameterNoException ( "setactivuserquery");
		if ($setactivuserquery == "yes"){
			$activeUserSetting = $this->request->getParameterNoException("disableuser");
			
			
			$modelCoreConfig->setParam("user_desactivate", $activeUserSetting);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menus' => $menus,
					'activeUserSetting' => $activeUserSetting
						
			) );
			return;
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'menus' => $menus, 
									 'activeUserSetting' => $activeUserSetting
		) );
	}
	
	public function uploadTemplate(){
		$target_dir = "data/";
		$target_file = $target_dir . "template.xls";
		$uploadOk = 1;
		$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000000) {
			return "Error: your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "xls") {
			return "Error: only xls files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return  "Error: your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				return  "The file template file". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				return "Error, there was an error uploading your file.";
			}
		}
	
	}
}