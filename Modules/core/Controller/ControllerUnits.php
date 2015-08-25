<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Unit.php';
class ControllerUnits extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $unitModel;
	
	// private $billet;
	public function __construct() {
		// $this->billet = new Billet ();
		$this->unitModel = new Unit ();
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
		$unitsArray = $this->unitModel->getUnits ( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'unitsArray' => $unitsArray 
		) );
	}
	public function edit() {
		$navBar = $this->navBar ();
		
		// get user id
		$unitId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unitId = $this->request->getParameter ( "actionid" );
		}
		
		// get unit info
		$unit = $this->unitModel->getUnit ( $unitId );
		
		//print_r ( $unit );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'unit' => $unit 
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
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$unitsArray = $this->unitModel->addUnit ( $name, $address );
		
		$this->redirect ( "units" );
	}
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$unitsArray = $this->unitModel->editUnit ( $id, $name, $address );
		
		$this->redirect ( "units" );
	}
		
	public function delete(){
	
		$unitId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$unitId = $this->request->getParameter("actionid");
		};
	
		$unitName = $this->unitModel->getUnitName($unitId);
	
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'unitName' => $unitName,
				'unitId' => $unitId
		) );
	}
	
	public function deletequery(){
	
		$unitId = $this->request->getParameter("id");
		$user = $this->unitModel->delete($unitId);
	
		// generate view
		$this->redirect("units");
	}
}