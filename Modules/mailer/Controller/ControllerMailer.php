<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';

class ControllerMailer extends ControllerSecureNav {

	public function __construct() {
	}

	// Affiche la liste de tous les billets du blog
	public function index() {

		$navBar = $this->navBar();

		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		$modelArea = new SyArea();
		$areasList = $modelArea->getUnrestrictedAreasIDName(); 
		
		$modelResource = new SyResource();
		$resourcesList = array();
		foreach($areasList as $area){
			$resourcesList[] = $modelResource->resourceIDNameForArea($area["id"]);
		}
		
		$modelUser = new User();
		$user = $modelUser->userAllInfo($_SESSION["id_user"]);
		$from = $user["email"];
		
		// From
		// To
		// Object
		// Content
		
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
			$modelUser = new User();
			$toAdress = $modelUser->getAllActifEmails();
		}
		else{
			$toEx = explode("_", $to);
			if ($toEx[0] == "a"){ // area
				// get all the adresses of users who book in this area
				$modelCalEntry = new SyCalendarEntry();
				$toAdress = $modelCalEntry->getEmailsBookerArea($toEx[1]);
				
			}
			elseif($toEx[0] == "r"){
				// get all the adresses of users who book in this resource
				$modelCalEntry = new SyCalendarEntry();
				$toAdress = $modelCalEntry->getEmailsBookerResource($toEx[1]);
			}
		}
		
		//print_r($toAdress);
		
		// send the email
		require("externals/PHPMailer/class.phpmailer.php");
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->CharSet = "utf-8";
		$mail->SetFrom('$from', 'Expéditeur');
		$mail->Subject = $subject;
		$mail->Body = $content;
		
		foreach($toAdress as $addres){
			if ($addres[0] && $addres[0] != ""){
				echo $addres[0] . "<br/>";
				$mail->AddAddress($addres[0]);
			}
		}
		
		if(!$mail->Send()) {
			echo 'Message was not sent.';
			echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent.';
		}
		
	}
	
}