<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Status.php';

class ControllerStatus extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $statusModel;
	
	public function __construct() {
		$this->statusModel = new Status();
	}
	
	// affiche la liste des Status
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$statusArray = $this->statusModel->getStatus ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'status' => $statusArray 
		) );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get isotype id
		$statusId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$statusId = $this->request->getParameter ( "actionid" );
		}
		
		// get isotype info
		$status = $this->statusModel->getStatu ( $statusId );
		
		//print_r ( $isotype );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'status' => $status 
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
		$color = $this->request->getParameter ( "color" );
		
		// add query
		$this->statusModel->addStatus ( $name, $color );
		
		$this->redirect ( "status" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		$color = $this->request->getParameter ( "color" );
		
		// edit query
		$this->statusModel->editStatus ( $id, $name, $color );
		
		$this->redirect ( "status" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->statusModel->delete($id );
	
		$this->redirect ( "status" );
	}
}