<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/Unit.php';

/**
 * Manage the units (each user belongs to an unit)
 * 
 * @author sprigent
 *
 */
class ControllerUnits extends ControllerSecureNav {
	
	/**
	 * Check if the user have the right to view SyGRRif pages
	 * @return boolean
	 */
	private function secureCheck(){
		if ( $_SESSION["user_status"] < 3){
			echo "Permission denied ";
			return true;
		}
		return false;
	}
	
	/**
	 * User model object
	 */
	private $unitModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->unitModel = new Unit ();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		if($this->secureCheck()){
			return;
		}
		
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
	/**
	 * Edit an unit form
	 */
	public function edit() {
		
		if($this->secureCheck()){
			return;
		}
		
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
	/**
	 * Add a unit form
	 */
	public function add() {
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar ();
		
		$this->generateView ( array (
				'navBar' => $navBar 
		) );
	}
	/**
	 * Add a unit query to datbase
	 */
	public function addquery() {
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$unitsArray = $this->unitModel->addUnit ( $name, $address );
		
		$this->redirect ( "units" );
	}
	/**
	 * Edit an unit to database
	 */
	public function editquery() {
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$unitsArray = $this->unitModel->editUnit ( $id, $name, $address );
		
		$this->redirect ( "units" );
	}
		
	/**
	 * Remove an unit form confirm
	 */
	public function delete(){
	
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Remove an unit query to database
	 */
	public function deletequery(){
	
		if($this->secureCheck()){
			return;
		}
		
		$unitId = $this->request->getParameter("id");
		$user = $this->unitModel->delete($unitId);
	
		// generate view
		$this->redirect("units");
	}
}