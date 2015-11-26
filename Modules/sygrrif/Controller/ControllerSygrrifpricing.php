<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';

/**
 * SyGRRif management pages
 * @author sprigent
 *
 */
class ControllerSygrrifpricing extends ControllerSecureNav {

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
	 * Constructor
	 */
	public function __construct() {
		ob_end_clean();
	}

	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	
	// pricing
	/**
	 * List of pricings
	 */
	public function pricing(){	
		
		if($this->secureCheck()){
			return;
		}
		
		$sort = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sort = $this->request->getParameter("actionid");
		}
		
		// get the core belongings
		$modelBelonging = new CoreBelonging();
		$belongings = $modelBelonging->getAll();
		
		// get the sygrrig pricing
		$modelPricing = new SyPricing();
		$pricingArray = $modelPricing->getPrices("id");
		
		// add pricing with default setting if a new belonging had been added
		foreach($belongings as $bel){
			if ($bel["id"] > 1){
				$found = false;	
				foreach ($pricingArray as $pricing){
					if($bel["id"] == $pricing["id"]){
						$found = true;
						break;
					}
				}
				if ($found == false){
					$modelPricing->addUnique($bel["id"]);
				}
			}
		}
		$pricingArray = $modelPricing->getPrices("id");
		
		// prepare view
		$lang = $this->getLanguage();
		for ($i = 0 ; $i < count($pricingArray) ; $i++){
			$pricingArray[$i]["name"] = $modelBelonging->getName($pricingArray[$i]["id"]);
			if ($pricingArray[$i]["tarif_unique"] == 1){
				$pricingArray[$i]["tarif_unique"] = CoreTranslator::yes($lang);
			}
			else{
				$pricingArray[$i]["tarif_unique"] = CoreTranslator::no($lang);
			}
			if ($pricingArray[$i]["tarif_night"] == 1){
				$pricingArray[$i]["tarif_night"] = CoreTranslator::yes($lang);
			}
			else{
				$pricingArray[$i]["tarif_night"] = CoreTranslator::no($lang);
			}
			if ($pricingArray[$i]["tarif_we"] == 1){
				$pricingArray[$i]["tarif_we"] = CoreTranslator::yes($lang);
			}
			else{
				$pricingArray[$i]["tarif_we"] = CoreTranslator::no($lang);
			}
		}
		
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Pricings( $lang ) );
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton ( "sygrrifpricing/editpricing" );
		$table->addDeleteButton ( "sygrrifpricing/deletepricing" );
		$table->addPrintButton ( "sygrrifpricing/pricing/" );
		
		$tableContent = array (
				"id" => "ID",
				"name" => CoreTranslator::Name ( $lang ),
				"tarif_unique" => SyTranslator::Unique_price($lang),
				"tarif_night" => SyTranslator::Price_night($lang),
				"tarif_we" => SyTranslator::Price_weekend($lang) 
		);
		$tableHtml = $table->view ( $pricingArray, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	/**
	 * Form to edit a pricing
	 */
	public function editpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get user id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelPricing = new SyPricing();
		$pricing = $modelPricing->getPricing($id);
		
		$modelBelonging = new CoreBelonging();
		$pricing["name"] = $modelBelonging->getName($id);
		
		print_r($pricing);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'pricing' => $pricing
		) );
	}
	
	/**
	 * Query to edit a pricing
	 */
	public function editpricingquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$tarif_unique = $this->request->getParameter ( "tarif_unique" );
		$tarif_nuit = $this->request->getParameter ( "tarif_night" );
		$night_start = $this->request->getParameter ( "night_start" );
		$night_end = $this->request->getParameter ( "night_end" );
		$tarif_we = $this->request->getParameter ( "tarif_we" );
		
		$lundi = $this->request->getParameterNoException ( "lundi");
		$mardi = $this->request->getParameterNoException ( "mardi");
		$mercredi = $this->request->getParameterNoException ( "mercredi");
		$jeudi = $this->request->getParameterNoException ( "jeudi");
		$vendredi = $this->request->getParameterNoException ( "vendredi");
		$samedi = $this->request->getParameterNoException ( "samedi");
		$dimanche = $this->request->getParameterNoException ( "dimanche");
		
		if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
		if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
		if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
		if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
		if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
		if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
		if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
				
		$we_char = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;

		$modelPricing = new SyPricing();
		$modelPricing->editPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char);

		
		$this->redirect("sygrrifpricing", "pricing");
	}
	
	/**
	 * Form to generate a bill for a unit
	 */
	public function statpriceunits(){
	
		$lang = "En";
		if ( isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		// get the form parameters
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$unit_id = $this->request->getParameterNoException('unit');
		$responsible_id = $this->request->getParameterNoException('responsible');
		$export_type = $this->request->getParameterNoException('export_type');
	
		if ($searchDate_start != ""){
			$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
		}
		if ($searchDate_end != ""){
			$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
		}
	
		//echo "date start = " . $searchDate_start . "<br/>";
		//echo "date end = " . $searchDate_end . "<br/>";
	
		// get the selected unit
		$selectedUnitId = 0;
		if ($unit_id != ""){
			$selectedUnitId = $unit_id;
		}
	
		// get the responsibles for this unit
		$responsiblesList = array();
		$modelCalEntry = new SyCalendarEntry();
		if ($selectedUnitId > 0){
			$modeluser = new CoreUser();
				
			$responsiblesListInter = $modeluser->getResponsibleOfUnit($selectedUnitId);
			foreach ($responsiblesListInter as $respi){
	
				//print_r($respi);
				$startdate = explode("-", $searchDate_start);
				$startdate = mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]);
	
				$enddate = explode("-", $searchDate_end);
				$enddate = mktime(23, 59, 59, $enddate[1], $enddate[2], $enddate[0]);
	
				if ( $modelCalEntry->hasResponsibleEntry($respi["id"], $startdate, $enddate) == true){
					$responsiblesList[] = $respi;
				}
			}
		}
	
		// test if it needs to calculate output
		$errorMessage = '';
		if ($selectedUnitId != 0 && $responsible_id != ''){
				
			// test the dates
			$testPass = true;
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
				
			// if the form is correct, calculate the output
			if ($testPass){
				//return;
				if ($export_type > 0 && $export_type < 4 ){
					$this->output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
					return;
				}
			}
		}
	
		// get units list
		$modelUnit = new CoreUnit();
		$unitsListTmp = $modelUnit->unitsIDName();
		$unitsList = array();
	
		if (	$searchDate_start!= "" && $searchDate_end!= "" ){
			$startdate = explode("-", $searchDate_start);
			$startdate = mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]);
			$enddate = explode("-", $searchDate_end);
			$enddate = mktime(0, 0, 0, $enddate[1], $enddate[2], $enddate[0]);
			foreach ($unitsListTmp as $unit){
				if ($modelCalEntry->hasUnitEntry($unit["id"], $startdate, $enddate) == true){
					$unitsList[] = $unit;
				}
			}
		}
	
		//echo "date start = " . $searchDate_start . "<br/>";
		//echo "date end = " . $searchDate_end . "<br/>";
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'selectedUnitId' => $selectedUnitId,
				'responsiblesList' => $responsiblesList,
				'unitsList' => $unitsList,
				'errorMessage' => $errorMessage,
				'searchDate_start' => $searchDate_start,
				'searchDate_end' => $searchDate_end
		) );
	}
	
	/**
	 *  Generate bill query
	 */
	public function output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id){
	
		header_remove();
		if ($export_type == 1){
			// generate decompte
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateCounting($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
			//$errorMessage = "counting functionality not yet available";
		}
		if ($export_type == 2){
			// generate detail
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateDetail($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
			//$errorMessage = "detail functionality not yet available";
		}
		if ($export_type == 3){
			// generate bill
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateBill($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
		}
	}
	
}
