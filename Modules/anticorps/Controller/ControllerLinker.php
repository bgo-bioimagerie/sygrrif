<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Linker.php';

class ControllerLinker extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $linkerModel;
	
	public function __construct() {
		$this->linkerModel = new Linker();
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
		$linkersArray = $this->linkerModel->getLinkers ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'linkers' => $linkersArray 
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
		$linker = $this->linkerModel->getLinker ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'linker' => $linker 
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
		$this->linkerModel->addLinker ( $name );
		
		$this->redirect ( "linker" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->linkerModel->editLinker( $id, $name );
		
		$this->redirect ( "linker" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->linkerModel->delete($id );
	
		$this->redirect ( "linker" );
	}
}