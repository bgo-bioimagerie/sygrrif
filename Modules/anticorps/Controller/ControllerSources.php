<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/Source.php';

class ControllerSources extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $sourceModel;
	
	public function __construct() {
		$this->sourceModel = new Source ();
	}
	
	// affiche la liste des Sources
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$SourcesArray = $this->sourceModel->getSources ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'sources' => $SourcesArray 
		) );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get source id
		$sourceId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sourceId = $this->request->getParameter ( "actionid" );
		}
		
		// get source info
		$source = $this->sourceModel->getSource ( $sourceId );
		
		print_r ( $source );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'source' => $source 
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
		
		// get the user list
		$sourcesArray = $this->sourceModel->addSource ( $name );
		
		$this->redirect ( "sources" );
	}
	
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "nom" );
		
		// get the user list
		$sourcesArray = $this->sourceModel->editSource ( $id, $name );
		
		$this->redirect ( "sources" );
	}
	
	public function delete(){
		
		// get source id
		$sourceId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sourceId = $this->request->getParameter ( "actionid" );
		}
		
		// get source info
		$source = $this->sourceModel->delete($sourceId );
		
		$this->redirect ( "sources" );
	}
	
}