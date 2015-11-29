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
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam("sprojectsusersdatabase");
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
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
		$id_resp = $this->request->getParameter("id_resp");
		$number = $this->request->getParameter("number");
		$no_project = $this->request->getParameter("no_project");
		$total_ht = $this->request->getParameter("total_ht");
		$date_generated = $this->request->getParameter("date_generated");
		$date_paid = $this->request->getParameter("date_paid");
		$is_paid = $this->request->getParameter("is_paid");
		
		$date_generated = CoreTranslator::dateToEn($date_generated, $this->getLanguage());
		//$date_paid = CoreTranslator::dateToEn($date_paid, $this->getLanguage());
		
		$modelBillManager = new SpBill();
		$modelBillManager->editBills($id, $number, $no_project, $id_resp, $date_generated, $total_ht, $date_paid, $is_paid);
		
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
		
		$choices = array(SpTranslator::view($lang), SpTranslator::Export_csv($lang) );
		$choicesid = array(0,1);
		$myform->addSelect("exporttype", SpTranslator::ExportType($lang), $choices, $choicesid);
		$myform->setValidationButton("Ok", "sprojectsbillmanager/billsstats");
		
		$stats = "";
		if ($myform->check()){
			
			// run the database query
			$modelStat = new SpBill();
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
	
	protected function exportStats($stats, $begin_period, $end_period){
		
		$lang = $this->getLanguage();
		$content = SpTranslator::TotalNumberOfBills($lang) . ";";
		$content .= $stats["totalNumberOfBills"] . "\r\n";
		$content .= SpTranslator::TotalPrice($lang) . ";";
		$content .= $stats["totalPrice"] . " € HT" . "\r\n";
		$content .= "\r\n";
		
		$content .= SpTranslator::NumberOfAcademicBills($lang) . ";";
		$content .= $stats["numberOfAcademicBills"] . "\r\n";
		$content .= SpTranslator::TotalPriceOfAcademicBills($lang) . ";";
		$content .= $stats["totalPriceOfAcademicBills"] . " € HT" . "\r\n";
		$content .= "\r\n";
			      		
		$content .= SpTranslator::NumberOfPrivateBills($lang) . ";";
		$content .= $stats["numberOfPrivateBills"] . "\r\n";
		$content .= SpTranslator::TotalPriceOfPrivateBills($lang) . ";";
		$content .= $stats["totalPriceOfPrivateBills"] . " € HT" . "\r\n";
		$content .= "\r\n";
		
		$fileName = "statistics_invoice_" . $begin_period . "_" . $end_period;
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=".$fileName.".csv");
		echo $content;
		
	}
}