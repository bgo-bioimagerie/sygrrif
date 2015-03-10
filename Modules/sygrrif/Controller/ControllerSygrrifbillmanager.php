<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyBill.php';
require_once 'Modules/core/Model/CoreTranslator.php';

class ControllerSygrrifbillmanager extends ControllerSecureNav {
	
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
		
		$ModulesManagerModel = new ModulesManager();
		$projectStatus = $ModulesManagerModel->getDataMenusUserType("projects");
		
		// get bill list
		$modelBillManager = new SyBill();
		$billsList = array();
		if ($projectStatus > 0){
			$billsList = $modelBillManager->getBills($sortentry);
		}
		else{
			$billsList = $modelBillManager->getBillsUnit($sortentry);
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'billsList' => $billsList,
				'projectStatus' => $projectStatus
		) );
	}
	
	public function edit(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelBillManager = new SyBill();
		$billInfo = $modelBillManager->getBill($id);
		
		//print_r($billInfo);
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'billInfo' => $billInfo
		) );
	}
	
	public function editquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$id = $this->request->getParameter("id");
		$number = $this->request->getParameter("number");
		$date_generated = $this->request->getParameter("date_generated");
		$date_paid = $this->request->getParameter("date_paid");
		$is_paid = $this->request->getParameter("is_paid");
		
		
		if ($date_generated != ""){
			$date_generated = CoreTranslator::dateToEn($date_generated, $lang);
		}
		if ($date_paid != ""){
			$date_paid = CoreTranslator::dateToEn($date_paid, $lang);
		}
		
		$modelBillManager = new SyBill();
		$modelBillManager->editBills($id, $number, $date_generated, $date_paid, $is_paid);
		
		$this->redirect("sygrrifbillmanager");
		
	}
	
	public function removeentry(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		if ($id != ""){
			$modelBillManager = new SyBill();
			$modelBillManager->removeEntry($id);
		}
		$this->redirect("sygrrifbillmanager");
	}
	
	public function export(){
		
		$lang = "En";
		if ( isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		
		if ($searchDate_start != ""){
			$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
		}
		if ($searchDate_end != ""){
			$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
		}
		
		$testPass = true;
		$errorMessage = "";
		if ($searchDate_start == "" && $searchDate_end == ""){
			$testPass = false;
		}
		if ($searchDate_start != "" || $searchDate_end != ""){
			if ( $searchDate_start == ''){
				$errorMessage = "Please set a start date";
				$testPass = false;
			}
			if ( $searchDate_end == ''){
				$errorMessage = "Please set an end date";
				$testPass = false;
			}
			if ( $searchDate_end < $searchDate_start){
				$errorMessage = "The start date must be before the end date";
				$testPass = false;
			}
		}
		
		if ($testPass){
			// export the bill list to an xls file
			$modelBillManager = new SyBill();
			$modelBillManager->export($searchDate_start, $searchDate_end);
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'searchDate_start' => $searchDate_start,
				'searchDate_end' => $searchDate_end,
				'errorMessage' => $errorMessage
		) );
	} 
}