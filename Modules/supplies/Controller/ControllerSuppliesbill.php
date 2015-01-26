<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuUnit.php';
require_once 'Modules/supplies/Model/SuUser.php';
require_once 'Modules/supplies/Model/SuBillGenerator.php';

class ControllerSuppliesbill extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	public function __construct() {
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$unit_id = $this->request->getParameterNoException('unit');
		$responsible_id = $this->request->getParameterNoException('responsible');
		
		// get the selected unit
		$selectedUnitId = 0;
		if ($unit_id != "" && $unit_id >1){
			$selectedUnitId = $unit_id; 
		}
		
		// get the responsibles for this unit
		$responsiblesList = array();
		if ($selectedUnitId > 0){
			$modeluser = new SuUser();
			$responsiblesList = $modeluser->getResponsibleOfUnit($selectedUnitId);
		}
		
		if ($selectedUnitId != 0 && $responsible_id > 1){
				
			// if the form is correct, calculate the output
			$this->billOutput($selectedUnitId, $responsible_id);
			return;
		}
		
		// get units list
		$modelUnit = new SuUnit();
		$unitsList = $modelUnit->unitsIDName();
		
		$errorMessage = "";
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'unitsList' => $unitsList,
				'responsiblesList' => $responsiblesList,
				'errorMessage' => $errorMessage,
				'selectedUnitId' => $selectedUnitId
		) );
	}
	
	protected function billOutput($selectedUnitId, $responsible_id){
		$billgenaratorModel = new SuBillGenerator();
		$billgenaratorModel->generateBill($selectedUnitId, $responsible_id);
	}
}