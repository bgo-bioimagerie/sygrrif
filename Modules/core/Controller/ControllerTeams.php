<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Team.php';

class ControllerTeams extends ControllerSecureNav {
	
	/**
	 * Team model object
	 */
	private $teamModel;
	
	// private $billet;
	public function __construct() {
		// $this->billet = new Billet ();
		$this->teamModel = new Team ();
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$teamsArray = $this->teamModel->getTeams ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'teamsArray' => $teamsArray 
		) );
	}
	public function edit() {
		$navBar = $this->navBar ();
		
		// get user id
		$teamId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$teamId = $this->request->getParameter ( "actionid" );
		}
		
		// get unit info
		$team = $this->teamModel->getTeam ( $teamId );
		
		//print_r ( $team );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'team' => $team 
		) );
	}
	public function add() {
		$navBar = $this->navBar ();
		
		$this->generateView ( array (
				'navBar' => $navBar 
		) );
	}
	public function addquery() {
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$teamsArray = $this->teamModel->addTeam ( $name, $address );
		
		$this->redirect ( "teams" );
	}
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$this->teamModel->editTeam ( $id, $name, $address );
		
		$this->redirect ( "teams" );
	}
}