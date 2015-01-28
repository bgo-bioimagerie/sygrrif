<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuBill.php';

class ControllerSuppliesbillmanager extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	public function __construct() {
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		// get the sort entry
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get bill list
		$modelBillManager = new SuBill();
		$billsList = $modelBillManager->getBills($sortentry);
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'billsList' => $billsList
		) );
	}
	
	public function edit(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelBillManager = new SuBill();
		$billInfo = $modelBillManager->getBill($id);
		
		//print_r($billInfo);
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'billInfo' => $billInfo
		) );
	}
	
	public function editquery(){
		
		$id = $this->request->getParameter("id");
		$number = $this->request->getParameter("number");
		$date_generated = $this->request->getParameter("date_generated");
		$date_paid = $this->request->getParameter("date_paid");
		$is_paid = $this->request->getParameter("is_paid");
		
		$modelBillManager = new SuBill();
		$modelBillManager->editBills($id, $number, $date_generated, $date_paid, $is_paid);
		
		$this->redirect("suppliesbillmanager");
		
	}
	
	public function removeentry(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		if ($id != ""){
			$modelBillManager = new SuBill();
			$modelBillManager->removeEntry($id);
		}

		$this->redirect("suppliesbillmanager");
	}
}