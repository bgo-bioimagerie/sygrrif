<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Project.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';

class ControllerSygrrifstats extends ControllerBooking {

	public function __construct() {
	}

	public function index(){
		
	}
	
	// Affiche la liste de tous les billets du blog
	public function billproject() {

		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get the form parameters
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$project_id = $this->request->getParameterNoException('project_id');
		$pricing_type = $this->request->getParameterNoException('pricing_type');
		$pricing_id = $this->request->getParameterNoException('pricing_id');
		
		if ($searchDate_start != ""){
			$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
		}
		if ($searchDate_end != ""){
			$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
		}
		
		
		// test if it needs to calculate output
		$errorMessage = "";
		if ($project_id != 0 && $project_id != ""){
			//echo "enter to calculation";
			//return;
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
				$modelBill = new SyBillGenerator();
				$modelBill->generateProjectBill($searchDate_start, $searchDate_end, $project_id, $pricing_id, $pricing_type);
				return;
			}
		}
		
		// get the responsibles for this unit
		//$projects = array();
		$modelProject = new Project();
		$projects = $modelProject->openedProjectsIDName();
		//print_r($projects);
		//return;
		//echo "opened projects = " . count($projects);
		//return;
		
		// get the pricings
		$modelPricing = new SyPricing();
		$pricings = $modelPricing->pricingsIDName();
		
		//print_r($pricings);
		//return;
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'project_id' => $project_id,
				'projects' => $projects,
				'errorMessage' => $errorMessage,
				'searchDate_start' => $searchDate_start,
				'searchDate_end' => $searchDate_end,
				'pricing_type' => $pricing_type,
				'pricing_id' => $pricing_id,
				'pricings' => $pricings
		) );
	}
	
}