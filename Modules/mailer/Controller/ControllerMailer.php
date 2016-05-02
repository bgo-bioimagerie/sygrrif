<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/mailer/Model/MailerSend.php';
require_once 'Modules/core/Model/ModulesManager.php';

class ControllerMailer extends ControllerSecureNav {

	public function __construct() {
            parent::__construct();
        }

	// Affiche la liste de tous les billets du blog
	public function index() {

		$navBar = $this->navBar();

		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		$areasList = array();
		$resourcesList = array();
		
		$moduleManager = new ModulesManager();
		if ( $moduleManager->isDataMenu("sygrrif") ){
			$modelArea = new SyArea();
			$areasList = $modelArea->getUnrestrictedAreasIDName(); 
			
			$modelResource = new SyResource();
			$resourcesList = array();
			foreach($areasList as $area){
				$resourcesList[] = $modelResource->resourceIDNameForArea($area["id"]);
			}
		}
		
		$modelUser = new CoreUser();
		$user = $modelUser->userAllInfo($_SESSION["id_user"]);
		$from = $user["email"];
		
		$this->generateView ( array (
				'navBar' => $navBar, 
				'areasList' => $areasList,
				'resourcesList' => $resourcesList,
				'from' => $from
		) );
	}
	
	public function send(){
		$from = $this->request->getParameter ( "from");
		$to = $this->request->getParameter ( "to");
		$subject = $this->request->getParameter ( "subject");
		$content = $this->request->getParameter ( "content");
		
		// get the emails
		$toAdress = array();
		if($to == "all"){
			$modelUser = new CoreUser();
			$toAdress = $modelUser->getAllActifEmails();
		}
                elseif ($to == "managers") {
                        $modelUser = new CoreUser();
                        $toAdress = $modelUser->getActiveManagersEmails();
                }
		else{
			$toEx = explode("_", $to);
			if ($toEx[0] == "a"){ // area
				// get all the adresses of users who book in this area
				$modelCalEntry = new SyCalendarEntry();
				$toAdress = $modelCalEntry->getEmailsBookerArea($toEx[1]);
			}
			elseif($toEx[0] == "r"){ // resource
				// get all the adresses of users who book in this resource
				$modelCalEntry = new SyCalendarEntry();
				$toAdress = $modelCalEntry->getEmailsBookerResource($toEx[1]);
			}
		}
		
		// send the email
		$mailerModel = new MailerSend();
		$message = $mailerModel->sendEmail($from, Configuration::get("name"), $toAdress, $subject, $content);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'message' => $message
		) );
		
	}
}