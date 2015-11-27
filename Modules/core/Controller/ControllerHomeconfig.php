<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/LdapConfiguration.php';

/**
 * 
 * @author sprigent
 * 
 * Config the home page informations
 */
class ControllerHomeconfig extends ControllerSecureNav {

	/**
	 * Constructor
	 */
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
		
		$modelSettings = new CoreConfig();
		$logo = $modelSettings->getParam("logo");	
		$home_title = $modelSettings->getParam("home_title");
		$home_message = $modelSettings->getParam("home_message");
		
		
		$this->generateView ( array ('navBar' => $navBar,
									 'logo' => $logo,
									 'home_title' => $home_title,
									 'home_message' => $home_message 
		) );
	}

	/**
	 * Edit the home settings
	 */
	public function editquery(){
		
		// get the post parameters
		//$logo = $this->request->getParameter ("logo");
		$home_title = $this->request->getParameter ("home_title");
		$home_message = $this->request->getParameter ("home_message");
		
		$modelSettings = new CoreConfig();
		//$modelSettings->setParam("logo", $logo);
		$modelSettings->setParam("home_title", $home_title);
		$modelSettings->setParam("home_message", $home_message);

		$this->uploadLogo();
		$this->redirect("coreconfig");
	}
	
	/**
	 * Upload the sygrrif bill template
	 *
	 * @return string
	 */
	public function uploadLogo(){
		$target_dir = "Themes/";
		$target_file = $target_dir . $_FILES["logo"]["name"];
		$modelSettings = new CoreConfig();
		$modelSettings->setParam("logo", $target_file);
		$uploadOk = 1;
		$imageFileType = pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION);
	
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000000) {
			return "Error: your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
			return "Error: only jpeg, jpg, png, gif files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return  "Error: your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
				return  "The file logo file". basename( $_FILES["logo"]["name"]). " has been uploaded.";
			} else {
				return "Error, there was an error uploading your file.";
			}
		}
	}
}