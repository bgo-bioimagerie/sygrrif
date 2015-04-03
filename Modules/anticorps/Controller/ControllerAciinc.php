<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Aciinc.php';

class ControllerAciinc extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $aciincModel;
	
	public function __construct() {
		$this->aciincModel = new Aciinc();
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
		$aciincsArray = $this->aciincModel->getAciincs ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'aciincs' => $aciincsArray 
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
		$aciinc = $this->aciincModel->getAciinc ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'aciinc' => $aciinc 
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
		$this->aciincModel->addAciinc ( $name );
		
		$this->redirect ( "aciinc" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->aciincModel->editAciinc( $id, $name );
		
		$this->redirect ( "aciinc" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->aciincModel->delete($id );
	
		$this->redirect ( "aciinc" );
	}
}