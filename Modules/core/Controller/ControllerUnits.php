<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Unit.php';

class ControllerUnits extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $unitModel;
	
	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
		$this->unitModel = new Unit();
	}
	
	
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		// get the user list
		$unitsArray = $this->unitModel->getUnits($sortentry);
		
		
		$this->generateView ( array (
				'navBar' => $navBar, 'unitsArray' => $unitsArray 
		) );
	}
	
	
	public function edit(){
		/*
		$navBar = $this->navBar();
		
		// get user id
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		}
		
		// get user info
		$user = $this->userModel->userAllInfo($userId);
		// get status
		$modelStatus = new Status();
		$status = $modelStatus->allStatus();
		
		$this->generateView ( array (
				'navBar' => $navBar, 'user' => $user, 'statusList' => $status
		) );
		*/
	}
	
	public function add(){
		
		$navBar = $this->navBar();
		
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function addquery(){
		
		$navBar = $this->navBar();
		
		// get form variables
		$name = $this->request->getParameter("name");
		$address = $this->request->getParameter("address");
		
		// get the user list
		$unitsArray = $this->unitModel->addUnit($name, $address);
		
		$this->redirect("units");
		
	}
	
}