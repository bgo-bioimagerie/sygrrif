<?php
require_once 'Framework/Controller.php';
require_once 'Modules/projet/Model/exporter.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

class ControllerExportXml extends ControllerSecureNav {
	
	public function index(){
		
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
			$modelBillManager = new exporter();
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