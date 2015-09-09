<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/supplies/Model/SuInitDatabase.php';


class ControllerSuppliesconfig extends ControllerSecureNav {

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
		$status = $ModulesManagerModel->getDataMenusUserType("supplies");
		$menus[0] = array("name" => "supplies", "status" => $status);
		
		// user database
		$modelConfig = new CoreConfig();
		if (!$modelConfig->isKey("supliesusersdatabase")){
			$modelConfig->setParam("supliesusersdatabase", "core");
		}
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");

		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new SuInitDatabase();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'menus' => $menus,
    										 'supliesusersdatabase' => $supliesusersdatabase
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'menus' => $menus,
										 'supliesusersdatabase' => $supliesusersdatabase
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$menusStatus = $this->request->getParameterNoException("menus");
			
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("supplies", "supplies", $menusStatus[0], "glyphicon-shopping-cart");
			
			$status = $ModulesManagerModel->getDataMenusUserType("supplies");
			$menus[0] = array("name" => "supplies", "status" => $status);
			
			
			$this->generateView ( array ('navBar' => $navBar,
				                     'menus' => $menus,
									 'supliesusersdatabase' => $supliesusersdatabase
									 	
			) );
			return;
		}
		
		// set bill template section
		$templatequery = $this->request->getParameterNoException ( "templatequery");
		$templateMessage = "";
		if ($templatequery == "yes"){
			$templateMessage = $this->uploadTemplate();
			$this->generateView ( array ('navBar' => $navBar,
					'menus' => $menus,
					'templateMessage' => $templateMessage,
					'supliesusersdatabase' => $supliesusersdatabase
			) );
			return;
		}
		
		// set user database choice
		$usersquery = $this->request->getParameterNoException ( "usersquery");
		$usersquery = "";
		if ($usersquery == "yes"){
			
			$supliesusersdatabase = $this->request->getParameter("supliesusersdatabase");
			$modelConfig->setParam("supliesusersdatabase", $supliesusersdatabase);
			
			$this->generateView ( array ('navBar' => $navBar,
					'menus' => $menus,
					'supliesusersdatabase' => $supliesusersdatabase
			) );
			return;
		}
				
		// default
		$this->generateView ( array ('navBar' => $navBar,
				'menus' => $menus,
				'supliesusersdatabase' => $supliesusersdatabase
		) );
	}
	
	public function uploadTemplate(){
		$target_dir = "data/";
		$target_file = $target_dir . "template_supplies.xls";
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