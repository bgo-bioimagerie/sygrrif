<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Isotype.php';

class ControllerIsotypes extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $isotypeModel;
	
	public function __construct() {
		$this->isotypeModel = new Isotype ();
	}
	
	// affiche la liste des isotypes
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$isotypesArray = $this->isotypeModel->getIsotypes ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'isotypes' => $isotypesArray 
		) );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get isotype id
		$isotypeId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$isotypeId = $this->request->getParameter ( "actionid" );
		}
		
		// get isotype info
		$isotype = $this->isotypeModel->getIsotype ( $isotypeId );
		
		//print_r ( $isotype );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'isotype' => $isotype 
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
		
		// add query
		$isotypesArray = $this->isotypeModel->addIsotype ( $name );
		
		$this->redirect ( "isotypes" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// add query
		$isotypesArray = $this->isotypeModel->editIsotype ( $id, $name );
		
		$this->redirect ( "isotypes" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->isotypeModel->delete($id );
	
		$this->redirect ( "isotypes" );
	}
	
}