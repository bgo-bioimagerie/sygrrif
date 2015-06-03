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
		
		// booking settings
		$modelBookingSettings = new SyBookingSettings();
		$bookingSettings = $modelBookingSettings->entries();
		
		// series booking
		$modelCoreConfig = new CoreConfig();
		$seriesBooking = $modelCoreConfig->getParam("SySeriesBooking");
		$editBookingMailing = $modelCoreConfig->getParam("SySeriesBooking");
		
		// edit reservatin fields
		$editBookingDescriptionSettings = $modelCoreConfig->getParam("SyDescriptionFields");
		
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
    										 'isBookingMenu' => $isBookingMenu,
    										 'bookingSettings' => $bookingSettings,
    										 'seriesBooking' => $seriesBooking,
											 'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    										 'editBookingMailing' => $editBookingMailing
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'isSygrrifMenu' => $isSygrrifMenu,
					                     'isBookingMenu' => $isBookingMenu,
					                     'bookingSettings' => $bookingSettings,
										 'seriesBooking' => $seriesBooking,
					                     'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    								     'editBookingMailing' => $editBookingMailing
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
					$ModulesManagerModel->addDataMenu("sygrrif", "sygrrif", 3, "glyphicon-signal");
					$isSygrrifMenu = true;
				}
			}
			
			// booking menu
			$bookingMenu = $this->request->getParameterNoException ("bookingmenu");
			if ($sygrrifDataMenu != ""){
				if (!$ModulesManagerModel->isDataMenu("booking")){
					$ModulesManagerModel->addDataMenu("booking", "sygrrif/booking", 1, "glyphicon-calendar");
					$isBookingMenu = true;
				}
			}
				
			$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu,
									 'isBookingMenu' => $isBookingMenu,
									 'bookingSettings' => $bookingSettings,
									 'seriesBooking' => $seriesBooking,
									 'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    								 'editBookingMailing' => $editBookingMailing
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
					'bookingSettings' => $bookingSettings,
					'templateMessage' => $templateMessage,
					'seriesBooking' => $seriesBooking,
					'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
					'editBookingMailing' => $editBookingMailing
			) );
			return;
		}
		
		// set series booking option
		$seriesbookingquery = $this->request->getParameterNoException ( "seriesbookingquery");
		if ($seriesbookingquery == "yes"){
			
			$seriesBooking = $this->request->getParameterNoException ( "seriesBooking" );
			$modelCoreConfig = new CoreConfig();
			$modelCoreConfig->setParam("SySeriesBooking", $seriesBooking);
			
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'bookingSettings' => $bookingSettings,
					'seriesBooking' => $seriesBooking,
					'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
					'editBookingMailing' => $editBookingMailing
			) );
			return;
		}
		
		// set editbookingdescriptionquery
		$editbookingdescriptionquery = $this->request->getParameterNoException ( "editbookingdescriptionquery");
		if ($editbookingdescriptionquery == "yes"){
			
			$editBookingDescriptionSettings = $this->request->getParameterNoException ( "description_fields" );
			$modelCoreConfig = new CoreConfig();
			$modelCoreConfig->setParam("SyDescriptionFields", $editBookingDescriptionSettings);
				
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'bookingSettings' => $bookingSettings,
					'seriesBooking' => $seriesBooking,
					'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    				'editBookingMailing' => $editBookingMailing
			) );
			return;
		}
		
		// set editbookingmailingquery
		$editbookingmailingquery = $this->request->getParameterNoException ( "editbookingmailingquery");
		if ($editbookingmailingquery == "yes"){
			
			$editBookingMailing = $this->request->getParameterNoException ( "email_when" );
			$modelCoreConfig = new CoreConfig();
			$modelCoreConfig->setParam("SyEditBookingMailing", $editBookingMailing);
			
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'bookingSettings' => $bookingSettings,
					'seriesBooking' => $seriesBooking,
					'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
					'editBookingMailing' => $editBookingMailing
			) );
			return;
		}
		
		// set booking settings
		$setbookingoptionsquery = $this->request->getParameterNoException ( "setbookingoptionsquery");
		$bookingOptionMessage = "";
		if ($setbookingoptionsquery == "yes"){
			
			$modelBookingSetting = new SyBookingSettings();
			
			$tag_visible_rname = $this->request->getParameterNoException ( "tag_visible_rname" );
			$tag_title_visible_rname = $this->request->getParameterNoException ( "tag_title_visible_rname" );
			$tag_position_rname = $this->request->getParameterNoException ( "tag_position_rname" );
			$tag_font_rname = $this->request->getParameterNoException ( "tag_font_rname" );
			$modelBookingSetting->setEntry("User", $tag_visible_rname, $tag_title_visible_rname,
					$tag_position_rname, $tag_font_rname);
			
			
			$tag_visible_rphone = $this->request->getParameterNoException ( "tag_visible_rphone" );
			$tag_title_visible_rphone = $this->request->getParameterNoException ( "tag_title_visible_rphone" );
			$tag_position_rphone = $this->request->getParameterNoException ( "tag_position_rphone" );
			$tag_font_rphone = $this->request->getParameterNoException ( "tag_font_rphone" );
			$modelBookingSetting->setEntry("Phone", $tag_visible_rphone, $tag_title_visible_rphone, 
											$tag_position_rphone, $tag_font_rphone);
				
			$tag_visible_sdesc = $this->request->getParameterNoException ( "tag_visible_sdesc" );
			$tag_title_visible_sdesc = $this->request->getParameterNoException ( "tag_title_visible_sdesc" );
			$tag_position_sdesc = $this->request->getParameterNoException ( "tag_position_sdesc" );
			$tag_font_sdesc = $this->request->getParameterNoException ( "tag_font_sdesc" );
			$modelBookingSetting->setEntry("Short desc", $tag_visible_sdesc, $tag_title_visible_sdesc, 
											$tag_position_sdesc, $tag_font_sdesc);
			
			$tag_visible_desc = $this->request->getParameterNoException ( "tag_visible_desc" );
			$tag_title_visible_desc = $this->request->getParameterNoException ( "tag_title_visible_desc" );
			$tag_position_desc = $this->request->getParameterNoException ( "tag_position_desc" );
			$tag_font_desc = $this->request->getParameterNoException ( "tag_font_desc" );
			$modelBookingSetting->setEntry("Desc", $tag_visible_desc, $tag_title_visible_desc, 
											$tag_position_desc, $tag_font_desc);
			
			$bookingOptionMessage = "Changes have been saved";
			$bookingSettings = $modelBookingSettings->entries();
		
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'bookingOptionMessage' => $bookingOptionMessage,
					'bookingSettings' => $bookingSettings,
					'seriesBooking' => $seriesBooking,
					'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    				'editBookingMailing' => $editBookingMailing
			) );
			return;
		}
		
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu,
									 'isBookingMenu' => $isBookingMenu,
									 'bookingSettings' => $bookingSettings,
									 'seriesBooking' => $seriesBooking,
									 'editBookingDescriptionSettings' => $editBookingDescriptionSettings,
    								 'editBookingMailing' => $editBookingMailing
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