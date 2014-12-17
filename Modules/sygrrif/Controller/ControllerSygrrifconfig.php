<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';


class ControllerSygrrifconfig extends ControllerSecureNav {

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
		$isSygrrifMenu = $ModulesManagerModel->isDataMenu("sygrrif");
		$isBookingMenu = $ModulesManagerModel->isDataMenu("booking");
		
		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new SyInstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'isSygrrifMenu' => $isSygrrifMenu,
    										 'isBookingMenu' => $isBookingMenu
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'isSygrrifMenu' => $isSygrrifMenu,
					                     'isBookingMenu' => $isBookingMenu
			) );
			return;
		}
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ( "setmenusquery");
		if ($setmenusquery == "yes"){
			$ModulesManagerModel = new ModulesManager();
			
			// sygrrif data menu
			$sygrrifDataMenu = $this->request->getParameterNoException ("sygrrifdatamenu");
			if ($sygrrifDataMenu != ""){
				if (!$ModulesManagerModel->isDataMenu("sygrrif")){
					$ModulesManagerModel->addDataMenu("sygrrif", "sygrrif", 1);
					$isSygrrifMenu = true;
				}
			}
			
			// booking menu
			$bookingMenu = $this->request->getParameterNoException ("bookingmenu");
			if ($sygrrifDataMenu != ""){
				if (!$ModulesManagerModel->isDataMenu("booking")){
					$ModulesManagerModel->addDataMenu("booking", "sygrrif/booking", 2);
					$isBookingMenu = true;
				}
			}
				
			$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu,
									 'isBookingMenu' => $isBookingMenu	
			) );
			return;
			
		}
		
		// set bill template section
		$templatequery = $this->request->getParameterNoException ( "templatequery");
		$templateMessage = "";
		if ($templatequery == "yes"){
			$templateMessage = $this->uploadTemplate();
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'templateMessage' => $templateMessage
			) );
			return;
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu,
									 'isBookingMenu' => $isBookingMenu
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