<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/projet/Model/Projet_Calendar_Parametre.php';

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
	$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		// nav bar
		$navBar = $this->navBar();

		// activated menus list //les modules qui sont activé dans cette page 
		$ModulesManagerModel = new ModulesManager();
		$isSygrrifMenu = $ModulesManagerModel->isDataMenu("sygrrif");
		$isBookingMenu = $ModulesManagerModel->isDataMenu("booking");
		$isneurinfo= $ModulesManagerModel->isDataMenu("projetcalendar");
		$bookingSettings="";
		// booking settings
		//paramettre pour rendre les champs visibles ou pas dans le calendrier
		if(isset($isneurinfo)){
			$modelparametre= new Projet_Calendar_Parametre();
			$parametre=$modelparametre->entries(); 
		}
		else{
			$modelBookingSettings = new SyBookingSettings();
			$bookingSettings = $modelBookingSettings->entries();
		}
	
		
		// series booking // check instalation sygrrif
		$modelCoreConfig = new CoreConfig();
		$seriesBooking = $modelCoreConfig->getParam("SySeriesBooking");
		
		// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new SyInstall(); //creation des tables dans la base de donnée
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    					                     'installError' => $installError,
    					                     'isSygrrifMenu' => $isSygrrifMenu,
    										 'isBookingMenu' => $isBookingMenu,
    										 'isneurinfo'=> $isneurinfo,
    										 'bookingSettings' => $bookingSettings,
    											'parametre'=>$parametre,
    										 'seriesBooking' => $seriesBooking,
    											
    										
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'installSuccess' => $installSuccess,
					                     'isSygrrifMenu' => $isSygrrifMenu,
					                     'isBookingMenu' => $isBookingMenu,
										 'isneurinfo' => $isneurinfo,
					                     'bookingSettings' => $bookingSettings,
											'parametre'=>$parametre,
										 'seriesBooking' => $seriesBooking,
										
			) );
			return;
		}//fin if
		
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
									'isneurinfo'=>$isneurinfo,
									 'bookingSettings' => $bookingSettings,
									'parametre'=>$parametre,
									 'seriesBooking' => $seriesBooking
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
					'isneurinfo'=>$isneurinfo,
					'bookingSettings' => $bookingSettings,
					'parametre'=>$parametre,
					'templateMessage' => $templateMessage,
					'seriesBooking' => $seriesBooking
			) );
			return;
		}
		
		// set series booking option
		$seriesbookingquery = $this->request->getParameterNoException ( "seriesbookingquery");
		if ($seriesbookingquery == "yes"){
			
			$seriesBooking = $this->request->getParameterNoException ( "seriesBooking" );
			$modelCoreConfig = new CoreConfig();
			$modelCoreConfig->setParam("SySeriesBooking", $seriesBooking);
			$modelBookingSettings = new SyBookingSettings();
			$bookingSettings = $modelBookingSettings->entries();
			
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'isneurinfo'=>$isneurinfo,
					'bookingSettings' => $bookingSettings,
					'parametre'=>$parametre,
					'seriesBooking' => $seriesBooking
			) );
			return;
		}
		
		
		
		// set booking settings
		$setbookingoptionsquery = $this->request->getParameterNoException ( "setbookingoptionsquery");
		$bookingOptionMessage = "";
		if ($setbookingoptionsquery == "yes"){
			
		if(isset($isneurinfo)){
			$modelparametre=new Projet_Calendar_Parametre();
			$tag_visible_rname = $this->request->getParameterNoException ( "tag_visible_rname" );
			
			$tag_title_visible_rname = $this->request->getParameterNoException ( "tag_title_visible_rname" );
			$tag_position_rname = $this->request->getParameterNoException ( "tag_position_rname" );
			$tag_font_rname = $this->request->getParameterNoException ( "tag_font_rname" );
			$modelparametre->setEntry("User", $tag_visible_rname, $tag_title_visible_rname,
					$tag_position_rname, $tag_font_rname);
					
			// pour l'acronyme
			$tag_visible_acronyme = $this->request->getParameterNoException ( "tag_visible_acronyme" );
			
			$tag_title_visible_acronyme = $this->request->getParameterNoException ( "tag_title_visible_acronyme" );
			$tag_position_acronyme = $this->request->getParameterNoException ( "tag_position_acronyme" );
			$tag_font_acronyme = $this->request->getParameterNoException ( "tag_font_acronyme" );
			$retu= $modelparametre->setEntry("Acronyme", $tag_visible_acronyme, $tag_title_visible_acronyme,
					$tag_position_acronyme, $tag_font_acronyme);
			//Numéro de visite
			$tag_visible_numvisite = $this->request->getParameterNoException ( "tag_visible_numvisite" );
			$tag_title_visible_numvisite = $this->request->getParameterNoException ( "tag_title_visible_numvisite" );
			$tag_position_numvisite = $this->request->getParameterNoException ( "tag_position_numvisite" );
			$tag_font_numvisite = $this->request->getParameterNoException ( "tag_font_numvisite" );
			
			$modelparametre->setEntry("Numero de visite", $tag_visible_numvisite, $tag_title_visible_numvisite, 
											$tag_position_numvisite, $tag_font_numvisite);
			
			//Code d'anonymation 
			
			$tag_visible_codeanonyma = $this->request->getParameterNoException ( "tag_visible_codeanonyma" );
			$tag_title_visible_codeanonyma = $this->request->getParameterNoException ( "tag_title_visible_codeanonyma" );
			$tag_position_codeanonyma = $this->request->getParameterNoException ( "tag_position_codeanonyma" );
			$tag_font_codeanonyma = $this->request->getParameterNoException ( "tag_font_codeanonyma" );
			$modelparametre->setEntry("Code danonymisation", $tag_visible_codeanonyma, $tag_title_visible_codeanonyma, 
											$tag_position_codeanonyma, $tag_font_codeanonyma);	
			//commentaire
				$tag_visible_commentaire = $this->request->getParameterNoException ( "tag_visible_commentaire" );
			$tag_title_visible_commentaire = $this->request->getParameterNoException ( "tag_title_visible_commentaire" );
			$tag_position_commentaire = $this->request->getParameterNoException ( "tag_position_commentaire" );
			$tag_font_commentaire = $this->request->getParameterNoException ( "tag_font_commentaire" );
			$modelparametre->setEntry("Commentaire", $tag_visible_commentaire, $tag_title_visible_commentaire, 
											$tag_position_commentaire, $tag_font_commentaire);						
			$bookingOptionMessage = "Changes have been saved";
			$parametre=$modelparametre->entries(); 
		
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'isneurinfo'=>$isneurinfo,
					'bookingOptionMessage' => $bookingOptionMessage,
					'parametre' => $parametre,
					'seriesBooking' => $seriesBooking
			) );
			return; }
			else{
			
			$modelBookingSetting = new SyBookingSettings();
			//pour le  nom de la personne qui a réservé
			$tag_visible_rname = $this->request->getParameterNoException ( "tag_visible_rname" );
			$tag_title_visible_rname = $this->request->getParameterNoException ( "tag_title_visible_rname" );
			$tag_position_rname = $this->request->getParameterNoException ( "tag_position_rname" );
			$tag_font_rname = $this->request->getParameterNoException ( "tag_font_rname" );
			$modelBookingSetting->setEntry("User", $tag_visible_rname, $tag_title_visible_rname,
					$tag_position_rname, $tag_font_rname);
			
		
			//le numero de telehpone	
			$tag_visible_rphone = $this->request->getParameterNoException ( "tag_visible_rphone" );
			$tag_title_visible_rphone = $this->request->getParameterNoException ( "tag_title_visible_rphone" );
			$tag_position_rphone = $this->request->getParameterNoException ( "tag_position_rphone" );
			$tag_font_rphone = $this->request->getParameterNoException ( "tag_font_rphone" );
			$modelBookingSetting->setEntry("Phone", $tag_visible_rphone, $tag_title_visible_rphone, 
											$tag_position_rphone, $tag_font_rphone);
			
			// Short Description 
				
			$tag_visible_sdesc = $this->request->getParameterNoException ( "tag_visible_sdesc" );
			$tag_title_visible_sdesc = $this->request->getParameterNoException ( "tag_title_visible_sdesc" );
			$tag_position_sdesc = $this->request->getParameterNoException ( "tag_position_sdesc" );
			$tag_font_sdesc = $this->request->getParameterNoException ( "tag_font_sdesc" );
			$modelBookingSetting->setEntry("Short desc", $tag_visible_sdesc, $tag_title_visible_sdesc, 
											$tag_position_sdesc, $tag_font_sdesc);
			
			//Description
			
			$tag_visible_desc = $this->request->getParameterNoException ( "tag_visible_desc" );
			$tag_title_visible_desc = $this->request->getParameterNoException ( "tag_title_visible_desc" );
			$tag_position_desc = $this->request->getParameterNoException ( "tag_position_desc" );
			$tag_font_desc = $this->request->getParameterNoException ( "tag_font_desc" );
			$modelBookingSetting->setEntry("Desc", $tag_visible_desc, $tag_title_visible_desc, 
											$tag_position_desc, $tag_font_desc);
			
			$bookingSettings = $modelBookingSettings->entries();
		
			$this->generateView ( array ('navBar' => $navBar,
					'isSygrrifMenu' => $isSygrrifMenu,
					'isBookingMenu' => $isBookingMenu,
					'isneurinfo'=>$isneurinfo,
					'bookingOptionMessage' => $bookingOptionMessage,
					'bookingSettings' => $bookingSettings,
					'seriesBooking' => $seriesBooking
			) );
			return;
		}
		}
		$modelBookingSetting = new SyBookingSettings();
		$bookingSettings = $modelBookingSetting->entries();
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'isSygrrifMenu' => $isSygrrifMenu,
									 'isBookingMenu' => $isBookingMenu,
										'isneurinfo'=>$isneurinfo,
									 'bookingSettings' => $bookingSettings,
										'parametre'=>$parametre,
									 'seriesBooking' => $seriesBooking
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