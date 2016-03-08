<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Organe.php';

class ControllerOrganes extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $organeModel;
	
	public function __construct() {
		$this->organeModel = new Organe ();
	}
	
	// affiche la liste des Sources
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$OrganesArray = $this->organeModel->getOrganes ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'organes' => $OrganesArray 
		) );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get source id
		$organeId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$organeId = $this->request->getParameter ( "actionid" );
		}
		
		// get source info
		$organe = $this->organeModel->getOrgane ( $organeId );
		
		//print_r ( $organe );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'organe' => $organe 
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
		$name = $this->request->getParameter ( "nom" );
		
		// get the user list
		$organesArray = $this->organeModel->addOrgane ( $name );
		
		$this->redirect ( "organes" );
	}
	
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// get the user list
		$sourcesArray = $this->organeModel->editOrgane ( $id, $name );
		
		$this->redirect ( "organes" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->organeModel->delete($id );
	
		$this->redirect ( "organes" );
	}
}