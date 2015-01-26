<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Project.php';
class ControllerProjects extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $projectModel;
	
	// private $billet;
	public function __construct() {
		// $this->billet = new Billet ();
		$this->projectModel = new Project ();
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$projectsArray = $this->projectModel->getProjects ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'projectsArray' => $projectsArray 
		) );
	}
	public function edit() {
		$navBar = $this->navBar ();
		
		// get project id
		$projectId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$projectId = $this->request->getParameter ( "actionid" );
		}
		
		// get project info
		$project = $this->projectModel->getProject ( $projectId );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'project' => $project 
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
		$name = $this->request->getParameter ( "name" );
		$description = $this->request->getParameter ( "description" );
		
		// get the user list
		$projectsArray = $this->projectModel->addProject ( $name, $description );
		
		$this->redirect ( "projects" );
	}
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$description = $this->request->getParameter ( "description" );
		
		// get the user list
		$projectsArray = $this->projectModel->editProject ( $id, $name, $description );
		
		$this->redirect ( "projects" );
	}
}