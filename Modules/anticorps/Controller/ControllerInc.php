<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Inc.php';

class ControllerInc extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $incModel;
	
	public function __construct() {
		$this->incModel = new Inc();
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
		$incsArray = $this->incModel->getIncs ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'incs' => $incsArray 
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
		$inc = $this->incModel->getInc ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'inc' => $inc 
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
		$this->incModel->addInc ( $name );
		
		$this->redirect ( "inc" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->incModel->editInc( $id, $name );
		
		$this->redirect ( "inc" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->incModel->delete($id );
	
		$this->redirect ( "inc" );
	}
}