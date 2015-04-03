<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Dem.php';

class ControllerDem extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $prelevementModel;
	
	public function __construct() {
		$this->demModel = new Dem();
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
		$DemsArray = $this->demModel->getDems ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'dems' => $DemsArray 
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
		$dem = $this->demModel->getDem ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'dem' => $dem 
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
		$this->demModel->addDem ( $name );
		
		$this->redirect ( "dem" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->demModel->editDem( $id, $name );
		
		$this->redirect ( "dem" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->demModel->delete($id );
	
		$this->redirect ( "dem" );
	}
}