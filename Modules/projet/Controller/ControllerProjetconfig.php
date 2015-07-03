<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/projet/Model/neurinfoinstall.php';


class ControllerProjetconfig extends ControllerSecureNav {

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
		
		$status = $ModulesManagerModel->getDataMenusUserType("neurinfoprojet");
		$menuStatus = array("name" => "neurinfoprojet", "status" => $status);
		//activation du calendrier neurinfo (ajout reservation)
		$statuscalendar = $ModulesManagerModel->getDataMenusUserType("projetcalendar");
		$menuCalendar=array("name"=>"neurinfocalendar", "statuscalendar"=>$statuscalendar );
		// activation des pages pour la gestion  des tarifs 
		$statustarif =$ModulesManagerModel->getDataMenusUserType("TarifsNeurinfo");
		$menuTarif=array("name"=>"TarifsNeurinfo", "statustarif"=>$statustarif  );
		//activiation des pages pour la gestion des utilisateurs
		$statusUtilisateur =$ModulesManagerModel->getDataMenusUserType("UtilisateurNeurinfo");
		$menuUtilisateur=array("name"=>"UtilisateurNeurinfo", "statusUtilisateur"=> $statusUtilisateur);
		
		
		// set menus section
		$setmenusquery = $this->request->getParameterNoException ("setmenusquery");
		if ($setmenusquery == "yes"){
			$menuStatus = $this->request->getParameterNoException("projetmenu");
			$menuCalendar = $this->request->getParameterNoException("projetcalendar");
			$menuTarif =$this->request->getParameterNoException("TarifsNeurinfo");
			$menuUtilisateur=$this->request->getParameterNoException("UtilisateurNeurinfo");
			$ModulesManagerModel = new ModulesManager();
			$ModulesManagerModel->setDataMenu("neurinfoprojet", "projet/index", $menuStatus, "glyphicon glyphicon-align-justify");
			$ModulesManagerModel->setDataMenu("projetcalendar", "Reservation/index", $menuCalendar, "glyphicon glyphicon-pushpin");
			$ModulesManagerModel->setDataMenu("TarifsNeurinfo", "Tarifs/index", $menuTarif, "glyphicon glyphicon-euro");
			$ModulesManagerModel->setDataMenu("UtilisateurNeurinfo", "Utilisateur/index", $menuUtilisateur, "glyphicon glyphicon-paperclip");
			
			$status = $ModulesManagerModel->getDataMenusUserType("neurinfoprojet");
			$statuscalendar = $ModulesManagerModel->getDataMenusUserType("projetcalendar");
			$statustarif= $ModulesManagerModel->getDataMenusUserType("TarifsNeurinfo");
			$statusUtilisateur= $ModulesManagerModel->getDataMenusUserType("UtilisateurNeurinfo");
			$menuStatus = array("name" => "neurinfo", "status" => $status);
			$menuCalendar=array("name"=>"neurinfocalendar", "statuscalendar"=>$statuscalendar  );
			$menuTarif=array("name"=>"TarifsNeurinfo", "statustarif"=>$statustarif);
			$menuUtilisateur=array("name"=> "UtilisateurNeurinfo", "stattusUtilisateur"=>$statusUtilisateur);
			$this->generateView ( array ('navBar' => $navBar,
					'menuStatus' => $menuStatus,
					'menuCalendar' => $menuCalendar,
					'menuTarif' => $menuTarif,
					'menuUtilisateur'=> $menuUtilisateur
						
			) );
			return;
				
		}
	// install section
		$installquery = $this->request->getParameterNoException ( "installquery");
		if ($installquery == "yes"){
			try{
				$installModel = new neurinfoinstall();
				$installModel->createDatabase();
			}
			catch (Exception $e) {
    			$installError =  $e->getMessage();
    			$installSuccess = "<b>Success:</b> the database have been successfully installed";
    			$this->generateView ( array ('navBar' => $navBar, 
    			'menuStatus' => $menuStatus,
    			'menuCalendar' => $menuCalendar,
    			'menuTarif' => $menuTarif,
    			'menuUtilisateur'=> $menuUtilisateur
    					                     	
    			) );
    			return;
			}
			$installSuccess = "<b>Success:</b> the database have been successfully installed";
			$this->generateView ( array ('navBar' => $navBar, 
					                     'menuStatus' => $menuStatus,
										'installSuccess'=> $installSuccess,
										'menuCalendar' => $menuCalendar,
										'menuTarif' => $menuTarif,
										'menuUtilisateur'=> $menuUtilisateur
			) );
			return;
		}
	
		// default
		$this->generateView ( array ('navBar' => $navBar,
				                     'menuStatus' => $menuStatus,
									'menuCalendar' => $menuCalendar,
									'menuTarif' => $menuTarif,
									'menuUtilisateur'=> $menuUtilisateur
		) );
	}
}