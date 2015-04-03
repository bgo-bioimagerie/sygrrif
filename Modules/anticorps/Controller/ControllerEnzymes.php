<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Enzyme.php';

class ControllerEnzymes extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $prelevementModel;
	
	public function __construct() {
		$this->enzymeModel = new Enzyme();
	}
	
	// affiche la liste des Prelevements
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$EnzymesArray = $this->enzymeModel->getEnzymes ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'enzymes' => $EnzymesArray 
		) );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get isotype id
		$especeId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$especeId = $this->request->getParameter ( "actionid" );
		}
		
		// get isotype info
		$enzyme = $this->enzymeModel->getEnzyme ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'enzyme' => $enzyme 
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
		$this->enzymeModel->addEnzyme ( $name );
		
		$this->redirect ( "enzymes" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->enzymeModel->editEnzyme( $id, $name );
		
		$this->redirect ( "enzymes" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->enzymeModel->delete($id );
	
		$this->redirect ( "enzymes" );
	}
}