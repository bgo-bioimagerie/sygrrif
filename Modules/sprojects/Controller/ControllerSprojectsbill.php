<?php


require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpBillGenerator.php';

class ControllerSprojectsbill extends ControllerSecureNav {

	public function index() {
		
		$id_project = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id_project = $this->request->getParameter("actionid");
		}
		
		$modelBill = new SpBillGenerator();
		$modelBill->generateBill($id_project);
	}
}