<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyBill.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';

/**
 * Manage the bills: history of generated bills with status (generated, payed)
 * 
 * @author sprigent
 *
 */
class ControllerSygrrifbillmanager extends ControllerSecureNav {
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		// get the sort entry
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		$ModulesManagerModel = new ModulesManager();
		$projectStatus = $ModulesManagerModel->getDataMenusUserType("projects");
		
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                }
                
		// get bill list
		$modelBillManager = new SyBill();
		$billsList = array();
		if ($projectStatus > 0){
                    if ($isMultisite){
			$billsList = $modelBillManager->getBills($sortentry);
                    }
                    else{
                        $billsList = $modelBillManager->getBillsForManager($_SESSION["id_user"], $sortentry);
                    }
		}
		else{
                    if ($isMultisite){
			$billsList = $modelBillManager->getBillsUnit($sortentry);
                    }
                    else{
                        $billsList = $modelBillManager->getBillsUnitForManager($_SESSION["id_user"], $sortentry);
                    }
		}
		
		$lang = $this->getLanguage();
		for($i = 0 ; $i < count($billsList) ; $i++){
			$billsList[$i]["responsible"] = $billsList[$i]['resp_name'] . " " . $billsList[$i]['resp_firstname'];
			if ($billsList[$i]['is_paid'] == 1){
				$billsList[$i]['is_paid'] = SyTranslator::Yes($lang);
			}
			else{
				$billsList[$i]['is_paid'] = SyTranslator::No($lang);
			}
			$billsList[$i]['period_begin'] = CoreTranslator::dateFromEn($billsList[$i]['period_begin'], $lang);
			$billsList[$i]['period_end'] = CoreTranslator::dateFromEn($billsList[$i]['period_end'], $lang);
			$billsList[$i]['date_generated'] = CoreTranslator::dateFromEn($billsList[$i]['date_generated'], $lang);
			$billsList[$i]['date_paid'] = CoreTranslator::dateFromEn($billsList[$i]['date_paid'], $lang);
		}
		
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Bills_manager( $lang ) );
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton ( "sygrrifbillmanager/edit" );
		$table->addDeleteButton ( "sygrrifbillmanager/removeentry", "id", "number" );
		$table->addPrintButton ( "sygrrifbillmanager/index/" );
		
		if ($projectStatus > 0){
			$tableContent = array (
					"number" => SyTranslator::Number($lang),
					"id_project" => SyTranslator::Project($lang),
					"period_begin" => SyTranslator::Period_begin($lang),
					"period_end" => SyTranslator::Period_end($lang),
					"date_generated" => SyTranslator::Date_Generated($lang),
					"total_ht" => SyTranslator::TotalHT($lang),
					"date_paid" => SyTranslator::Date_Paid($lang),
					"is_paid" => SyTranslator::Is_Paid($lang)
					);
		}
		else{
			$tableContent = array (
				"number" => SyTranslator::Number($lang),
				"responsible" => SyTranslator::Responsible($lang),
				"unit" =>  SyTranslator::Unit($lang),
				"period_begin" => SyTranslator::Period_begin($lang),
				"period_end" => SyTranslator::Period_end($lang),
				"date_generated" => SyTranslator::Date_Generated($lang),
				"total_ht" => SyTranslator::TotalHT($lang),
				"date_paid" => SyTranslator::Date_Paid($lang),
				"is_paid" => SyTranslator::Is_Paid($lang)
			);
		}
		$tableHtml = $table->view ( $billsList, $tableContent );
		
		//$print = $this->request->getParameterNoException ( "print" );
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
	
	/**
	 * Form to edit a bill history
	 */
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
	
	/**
	 * Query to edit a bill history
	 */
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
		$total_ht = $this->request->getParameter("total_ht");
		
		
		if ($date_generated != ""){
			$date_generated = CoreTranslator::dateToEn($date_generated, $lang);
		}
		if ($date_paid != ""){
			$date_paid = CoreTranslator::dateToEn($date_paid, $lang);
		}
		
		$modelBillManager = new SyBill();
		$modelBillManager->editBills($id, $number, $date_generated, $total_ht, $date_paid, $is_paid);
		
		$this->redirect("sygrrifbillmanager");
		
	}
	
	/**
	 * Query to remove a bill from history
	 */
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
	
	/**
	 * Export the bill list to file
	 */
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