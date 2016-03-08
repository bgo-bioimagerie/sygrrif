<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Prelevement.php';

class ControllerPrelevements extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $prelevementModel;
	
	public function __construct() {
		$this->prelevementModel = new Prelevement();
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
		$PrelevementsArray = $this->prelevementModel->getPrelevements ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'prelevements' => $PrelevementsArray 
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
		$prelevement = $this->prelevementModel->getPrelevement ( $especeId );
		
		//print_r ( $isotype );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'prelevement' => $prelevement 
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
		$this->prelevementModel->addPrelevement ( $name );
		
		$this->redirect ( "prelevements" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->prelevementModel->editPrelevement( $id, $name );
		
		$this->redirect ( "prelevements" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->prelevementModel->delete($id );
	
		$this->redirect ( "prelevements" );
	}
}