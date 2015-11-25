<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/sprojects/Model/SpBill.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';

class ControllerSprojectsbillmanager extends ControllerSecureNav {
	
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
		$modelBillManager = new SpBill();
		$billsList = $modelBillManager->getBills($sortentry);
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$table = new TableView ();
		$table->setTitle ( SpTranslator::sprojects_bill( $lang ) );
		$table->addLineEditButton ( "sprojectsbillmanager/edit" );
		$table->addDeleteButton ( "sprojectsbillmanager/removeentry", "id", "number" );
		$table->addPrintButton ( "sprojectsbillmanager/index/" );
		
		$tableContent = array (
				"number" => SpTranslator::Number($lang), 
				"no_project" => SpTranslator::Project_number($lang),
				"id_resp" => CoreTranslator::Responsible($lang),
				"date_generated" => SpTranslator::Date_generated($lang), 
				"total_ht" => SpTranslator::Total_HT($lang), 
				"date_paid" => SpTranslator::Date_paid($lang), 
				"is_paid" => SpTranslator::Is_Paid($lang)
		);
		// is restricted translation
		$modelUser = new User();
		for($i = 0; $i < count ( $billsList ); $i ++) {
			
			$billsList[$i]["date_generated"] = CoreTranslator::dateFromEn($billsList[$i]["date_generated"], $lang);
			$billsList[$i]["date_paid"] = CoreTranslator::dateFromEn($billsList[$i]["date_paid"], $lang);
			if ($billsList[$i]["is_paid"] > 0){
				$billsList[$i]["is_paid"] = CoreTranslator::yes($lang);
			}	
			else{
				$billsList[$i]["is_paid"] = CoreTranslator::no($lang);
			}
			$billsList[$i]["id_resp"] = $modelUser->getUserFUllName($billsList[$i]["id_resp"]);
		}
		
		$tableHtml = $table->view ( $billsList, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	public function edit(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelBillManager = new SpBill();
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
		
		$modelBillManager = new SpBill();
		$modelBillManager->editBills($id, $number, $date_generated, $date_paid, $is_paid);
		
		$this->redirect("sprojectsbillmanager");
		
	}
	
	public function removeentry(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		if ($id != ""){
			$modelBillManager = new SpBill();
			$modelBillManager->removeEntry($id);
		}

		$this->redirect("sprojectsbillmanager");
	}
	
	public function billsstats(){
		
		$lang = $this->getLanguage();
		
		// build the form
		$myform = new Form($this->request, "formstatsbills");
		$myform->setTitle(SpTranslator::Bills_statistics($lang));
		$myform->addDate("begining_period", SpTranslator::Beginning_period($lang), true, "0000-00-00");
		$myform->addDate("end_period", SpTranslator::End_period($lang), true, "0000-00-00");
		$myform->setValidationButton("Ok", "sprojectsbillmanager/billsstats");
		
		$stats = "";
		if ($myform->check()){
			// run the database query
			$modelStat = new SpBill();
			$stats = $modelStat->computeStats($myform->getParameter("begining_period"), $myform->getParameter("end_period"));
		}
		
		// set the view
		$formHtml = $myform->getHtml();
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'formHtml' => $formHtml,
				'stats' => $stats
		) );
	}
}