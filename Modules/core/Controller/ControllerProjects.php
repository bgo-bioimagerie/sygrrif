<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Project.php';

/**
 * 
 * @author sprigent
 * Project database (extend this class if you need a project module)
 */
class ControllerProjects extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $projectModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->projectModel = new Project ();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
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
	/**
	 * Edit a project form
	 */
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
	/**
	 * Add a project form
	 */
	public function add() {
		$navBar = $this->navBar ();
		
		$this->generateView ( array (
				'navBar' => $navBar 
		) );
	}
	/**
	 * add project query to database
	 */
	public function addquery() {
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$description = $this->request->getParameter ( "description" );
		
		// get the user list
		$projectsArray = $this->projectModel->addProject ( $name, $description );
		
		$this->redirect ( "projects" );
	}
	/**
	 * edit project query to database
	 */
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$description = $this->request->getParameter ( "description" );
		$status = $this->request->getParameter ( "status" );
		
		// get the user list
		$projectsArray = $this->projectModel->editProject ( $id, $name, $description );
		$this->projectModel->setStatus($id, $status);
		
		$this->redirect ( "projects" );
	}
}