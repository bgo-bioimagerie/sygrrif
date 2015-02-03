<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Espece.php';

class ControllerEspeces extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $especeModel;
	
	public function __construct() {
		$this->especeModel = new Espece();
	}
	
	// affiche la liste des especes
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$especesArray = $this->especeModel->getEspeces ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'especes' => $especesArray 
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
		$espece = $this->especeModel->getEspece ( $especeId );
		
		//print_r ( $isotype );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'espece' => $espece 
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
		$this->especeModel->addEspece ( $name );
		
		$this->redirect ( "especes" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->especeModel->editEspece ( $id, $name );
		
		$this->redirect ( "especes" );
	}
}