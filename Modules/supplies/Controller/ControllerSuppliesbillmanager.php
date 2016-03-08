<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/supplies/Model/SuBill.php';
require_once 'Modules/supplies/Model/SuUser.php';
require_once 'Modules/supplies/Model/SuTranslator.php';

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
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$table = new TableView ();
		$table->setTitle ( SuTranslator::supplies_bill( $lang ) );
		$table->addLineEditButton ( "suppliesbillmanager/edit" );
		$table->addDeleteButton ( "suppliesbillmanager/removeentry", "id", "number" );
		$table->addPrintButton ( "suppliesbillmanager/index/" );
		
		$tableContent = array (
				"number" => SuTranslator::Number($lang),
				"id_resp" => CoreTranslator::Responsible($lang),
				"date_generated" => SuTranslator::Date_generated($lang), 
				"total_ht" => SuTranslator::Total_HT($lang), 
				"date_paid" => SuTranslator::Date_paid($lang), 
				"is_paid" => SuTranslator::Is_Paid($lang)
		);
		// is restricted translation
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		if ($supliesusersdatabase == "local"){
			$modelUser = new SuUser();
		}
		else{
			$modelUser = new CoreUser();
		}
		
		
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
		$id_unit = $this->request->getParameter("id_unit");
		$id_resp = $this->request->getParameter("id_resp");
		$total_ht = $this->request->getParameter("total_ht");
		$date_generated = $this->request->getParameter("date_generated");
		$date_paid = $this->request->getParameter("date_paid");
		$is_paid = $this->request->getParameter("is_paid");
		
		$modelBillManager = new SuBill();
		$modelBillManager->editBills($id, $number, $id_unit, $id_resp, $date_generated, $total_ht, $date_paid, $is_paid);
		
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
	
	public function billsstats(){
		
		$lang = $this->getLanguage();
		
		// build the form
		$myform = new Form($this->request, "formstatsbills");
		$myform->setTitle(SuTranslator::Bills_statistics($lang));
		$myform->addDate("begining_period", SuTranslator::Beginning_period($lang), true, "0000-00-00");
		$myform->addDate("end_period", SuTranslator::End_period($lang), true, "0000-00-00");
		
		$choices = array(SuTranslator::view($lang), SuTranslator::Export_csv($lang) );
		$choicesid = array(0,1);
		$myform->addSelect("exporttype", SuTranslator::ExportType($lang), $choices, $choicesid);
		$myform->setValidationButton("Ok", "suppliesbillmanager/billsstats");
		
		$stats = "";
		if ($myform->check()){
			
			// run the database query
			$modelStat = new SuBill();
			$stats = $modelStat->computeStats($myform->getParameter("begining_period"), $myform->getParameter("end_period"));
			
			if ($myform->getParameter("exporttype") == 1){
				$this->exportStats($stats, $myform->getParameter("begining_period"), $myform->getParameter("end_period"));
				return;
			}
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