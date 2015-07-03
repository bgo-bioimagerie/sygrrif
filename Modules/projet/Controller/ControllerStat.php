<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Project.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyReport.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/projet/Model/Pr_stat.php';

class ControllerStat extends ControllerBooking {

	public function __construct() {
	}

	public function index(){
		
	}
	
	// Affiche la liste de tous les billets du blog
	
	
	public function report(){
		
		$navBar = $this->navBar();
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		$ModulesManagerModel = new ModulesManager();
		$isneurinfo= $ModulesManagerModel->isDataMenu("projetcalendar");
		if(isset($isneurinfo)){
		$isrequest = $this->request->getParameterNoException('is_request');
		if ($isrequest == "y"){
		
			// get the form parameters
			$searchDate_start = $this->request->getParameterNoException('searchDate_start');
			$searchDate_end = $this->request->getParameterNoException('searchDate_end');
			
			if ($searchDate_start != ""){
				$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
			}
			if ($searchDate_end != ""){
				$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
			}
			
			if ($searchDate_start == "" || $searchDate_end == ""){
				$errormessage = "You must specify a start date and an end date";
				$this->generateView ( array (
						'navBar' => $navBar,
						'errorMessage' => $errormessage
				) );
				return;
			}
			
			// convert start date to unix date
			$tabDate = explode("-",$searchDate_start);
			$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
			$searchDate_s= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
			
			// convert end date to unix date
			$tabDate = explode("-",$searchDate_end);
			$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
			$searchDate_e= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
			
			if( $searchDate_e <= $searchDate_s){
				$errormessage = "The start date must be before the end date";
				$this->generateView ( array (
						'navBar' => $navBar,
						'errorMessage' => $errormessage,
						'searchDate_start' => $searchDate_start,
						'searchDate_end' => $searchDate_end,
						'isneurinfo'=> $isneurinfo
				) );
				return;
			}
			
			$champ = $this->request->getParameterNoException('champ');
			$type_recherche = $this->request->getParameterNoException('type_recherche');
			$text = $this->request->getParameterNoException('text');
			$contition_et_ou = $this->request->getParameterNoException('condition_et_ou');
			$entrySummary = $this->request->getParameterNoException('summary_rq');
			
			//print_r($champ);
			//print_r($type_recherche);
			//print_r($text);
			
			$reportModel = new Pr_stat();
			$table = $reportModel->reportstats($searchDate_s, $searchDate_e, $champ, $type_recherche, $text, $contition_et_ou);
			
			//print_r($table);
			
			$outputType = $this->request->getParameterNoException('output');
			
			if ($outputType == 1){ // only details
				$this->generateView ( array (
						'navBar' => $navBar,
						'searchDate_start' => $searchDate_start,
						'searchDate_end' => $searchDate_end,
						'champ' => $champ,
						'type_recherche' => $type_recherche,
						'text' => $text,
						'summary_rq' => $entrySummary,
						'output' => $outputType,
						'table' => $table,
						'isneurinfo'=> $isneurinfo
				) );
				return;
			}
			else if ($outputType == 2){ // only summary
				
				$summaryTable = $reportModel->summaryseReportStats($table, $entrySummary);
				$this->generateView ( array (
						'navBar' => $navBar,
						'searchDate_start' => $searchDate_start,
						'searchDate_end' => $searchDate_end,
						'champ' => $champ,
						'type_recherche' => $type_recherche,
						'text' => $text,
						'summary_rq' => $entrySummary,
						'output' => $outputType,
						'summaryTable' => $summaryTable,
						'isneurinfo'=> $isneurinfo
				) );
				return;
			}
			else if ($outputType == 3){ // details and summary
				$summaryTable = $reportModel->summaryseReportStats($table, $entrySummary);
				$this->generateView ( array (
						'navBar' => $navBar,
						'searchDate_start' => $searchDate_start,
						'searchDate_end' => $searchDate_end,
						'champ' => $champ,
						'type_recherche' => $type_recherche,
						'text' => $text,
						'summary_rq' => $entrySummary,
						'output' => $outputType,
						'table' => $table,
						'summaryTable' => $summaryTable,
						'isneurinfo'=> $isneurinfo
				) );
				return;
			}
			else if ($outputType == 4){ // details csv
				$this->exportDetailsCSVNI($table, $lang);
				return;	
			}
			else if ($outputType == 5){ // summary csv
				$summaryTable = $reportModel->summaryseReportStats($table, $entrySummary);
				$this->exportSummaryCSVNI($summaryTable, $lang);
				return;
			}
		}
		
		$this->generateView ( array (
				'navBar' => $navBar
		) );
		
		
		
		
		}
	}
	
	
	private function exportDetailsCSVNI($table, $lang){
		
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=rapport.csv");
		
		$content = "";
		$content.=	SyTranslator::Area($lang)  . " ; "
				.	SyTranslator::Resource($lang)  . " ; "
				.	SyTranslator::Active_Authorizations($lang)  . " ; "
				.	SyTranslator::Date($lang) . " ; "
				.	SyTranslator::codeanonymation($lang). " ; "
				.	SyTranslator::numreservation($lang). " ; "
				.	SyTranslator::Color_code($lang)  . " ; "
				.	SyTranslator::recipient($lang)  . " \r\n";
		

	   foreach ($table as $t){
	   		$content.=  $t["area_name"] . "; ";
	   		$content.=  $t["resource"] . "; ";
	   		$content.=  $t["acronyme"] . "; ";
	   		    
		    $date = date( "d/m/Y à H:i", $t["start_time"]) . " - ";
		    $date .= date( "d/m/Y à H:i", $t["end_time"]);
		           
		    $content.=  $date . ";"; 
		    $content.=  $t["codeanonyma"] . "; ";
		    $content.=  $t["numerovisite"] . "; ";
		    $content.=  $t["color"] . "; ";
		    $content.=  $t["login"] . " ";
		    $content.= "\r\n";
	   }
	   echo $content;
	}
	
	
	private function exportSummaryCSVNI($summaryTable, $lang){
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=rapport.csv");
	
		$countTable = $summaryTable['countTable'];
		$timeTable = $summaryTable['timeTable'];
		$resourcesNames = $summaryTable['resources'];
		$entrySummary = $summaryTable['entrySummary'];
		
		$content = "";
		
		// head
		$content .= " ; ";
		foreach ($resourcesNames as $name){
		   $content .=  $name . " ; ";
		}	 
		$content .= "Total \r\n"; 
		  
		// body   
		$i = -1;
		$totalCG = 0;
		$totalHG = 0;
		foreach ($countTable as $coutT){
			$i++;
			$content .= $entrySummary[$i] . " ; ";
		   	$j = -1;
		   	$totalC = 0;
		   	$totalH = 0;
		   	foreach ($coutT as $col){
		   		$j++;
		   		$content .= "(" . $col . ") " . $timeTable[$entrySummary[$i]][$resourcesNames[$j]]/3600 . " ; ";
		   		$totalC += $col;
		   		$totalH += $timeTable[$entrySummary[$i]][$resourcesNames[$j]];
		   	}
		   	$content .= "(" . $totalC . ") " . $totalH/3600 . " ";
		   	$content .= "\r\n";
		   	$totalCG += $totalC;
		   	$totalHG += $totalH;
		}
		
		// total line   
		$content .= "Total ; ";
		for ($i = 0 ; $i < count($resourcesNames) ; $i++){
			// calcualte the sum
		   	$sumC = 0;
		   	$sumH = 0;
		   	for ($x = 0 ; $x < count($entrySummary) ; $x++){
		   		$sumC += $countTable[$entrySummary[$x]][$resourcesNames[$i]];
		   		$sumH += $timeTable[$entrySummary[$x]][$resourcesNames[$i]];
		   	}
		   	$content .= "(" . $sumC . ") " . $sumH/3600 . " ; "; 
		}
		$content .= "(" . $totalCG .")". $totalHG/3600;
		$content .= " \r\n ";
		echo $content;
	}
}