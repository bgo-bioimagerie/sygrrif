<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcOption.php';

class ControllerOption extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $optionModel;
	
	public function __construct() {
		$this->optionModel = new AcOption();
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
		$optionsArray = $this->optionModel->getOptions ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'options' => $optionsArray 
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
		$option = $this->optionModel->getOption ( $especeId );
		
		//print_r ( $isotype );
		$this->generateView ( array (
				'navBar' => $navBar,
				'option' => $option 
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
		$this->optionModel->addOption ( $name );
		
		$this->redirect ( "option" );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// edit query
		$this->optionModel->editOption( $id, $name );
		
		$this->redirect ( "option" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->optionModel->delete($id );
	
		$this->redirect ( "option" );
	}
}