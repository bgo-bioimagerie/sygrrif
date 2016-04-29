<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreProject.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyReport.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Framework/Form.php';
require_once 'Modules/sygrrif/Model/SyStatsUser.php';

/**
 * Controller to export the SyGRRif stats
 * 
 * @author sprigent
 *
 */
class ControllerSygrrifstats extends ControllerBooking {

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
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index(){
		
	}
	
	/**
	 * Statistics form pages
	 */
	public function statistics(){
	
		if($this->secureCheck()){
			return;
		}
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Calculate an view the statistics
	 */
	public function statisticsquery(){
	
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		if($this->secureCheck()){
			return;
		}
	
		$month_start = $this->request->getParameter ( "month_start" );
		$year_start = $this->request->getParameter ( "year_start" );
		$month_end = $this->request->getParameter ( "month_end" );
		$year_end = $this->request->getParameter ( "year_end" );
		$export_type = $this->request->getParameter ( "export_type" );
	
		$modelGraph = new SyGraph();
		$graphArray = $modelGraph->getYearNumResGraph($month_start, $year_start, $month_end, $year_end);
		$graphTimeArray = $modelGraph->getYearNumHoursResGraph($month_start, $year_start, $month_end, $year_end);
	
		$modelResource = new SyResource();
		$resourcesNumber = $modelResource->resourcesNumber();
	
		$modelResourceC = new SyResourcesCategory();
		$resourcesCategoryNumber = $modelResourceC->categoriesNumber();
	
		//echo "resourcesNumber = " . $resourcesNumber . "<br/>";
	
		if($export_type == 1){
				
			$camembertContent = $modelGraph->getCamembertContent($month_start, $year_start, $month_end, $year_end, $graphArray['numTotal']);
			$camembertTimeContent = $modelGraph->getCamembertTimeContent($month_start, $year_start, $month_end, $year_end, $graphTimeArray['timeTotal']);
			$camembertContentResourcesType = $modelGraph->getCamembertContentResourceType($month_start, $year_start, $month_end, $year_end, $graphArray['numTotal']);
			$camembertTimeContentResourcesType = $modelGraph->getCamembertTimeContentResourceType($month_start, $year_start, $month_end, $year_end, $graphTimeArray['timeTotal']);
			//echo "time total = " . $graphTimeArray['timeTotal'] . "<br/>";
                        $navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'month_start' => $month_start,
					'year_start' => $year_start,
					'month_end' => $month_end,
					'year_end' => $year_end,
					'numTotal' => $graphArray['numTotal'],
					'graph' => $graphArray['graph'],
					'graph_month' => $graphArray['monthIds'],
					'graphTimeArray' => $graphTimeArray,
					'camembertContent' => $camembertContent,
					'camembertTimeContent' => $camembertTimeContent,
					'resourcesNumber' => $resourcesNumber,
					'camembertContentResourcesType' => $camembertContentResourcesType,
					'camembertTimeContentResourcesType' => $camembertTimeContentResourcesType,
					'resourcesCategoryNumber' => $resourcesCategoryNumber
			) );
		}
		else{
				
			$camembertCount = $modelGraph->getCamembertArray($month_start, $year_start, $month_end, $year_end);
			$camembertTimeCount = $modelGraph->getCamembertTimeArray($month_start, $year_start, $month_end, $year_end);
				
			header("Content-Type: application/csv-tab-delimited-table");
			header("Content-disposition: filename=rapport.csv");
				
			$content = "";
			// annual number
			$content .= SyTranslator::Annual_review_of_the_number_of_reservations_of($lang) . " " . Configuration::get("name") . "\r\n";
			$i = 0;
			foreach ($graphArray['graph'] as $g){
				$i++;
				$content .= $i . " ; " . $g . "\r\n";
			}
				
			// annual number
			$content .= "\r\n";
			$content .= SyTranslator::Annual_review_of_the_time_of_reservations_of($lang) . " " . Configuration::get("name") . "\r\n";
			$i=0;
			foreach ($graphTimeArray['graph'] as $g){
				$i++;
				$content .= $i . " ; " . $g . "\r\n";
			}
				
			// annual resources
			$content .= "\r\n";
			$content .= SyTranslator::Booking_number_year($lang) . " " . Configuration::get("name") . "\r\n";
			foreach ($camembertCount as $g){
				$content .= $g[0] . " ; " . $g[1] . "\r\n";
			}
				
			// annual resources
			$content .= "\r\n";
			$content .= SyTranslator::Booking_time_year($lang) . " " . Configuration::get("name") . "\r\n";
			foreach ($camembertTimeCount as $g){
				$content .= $g[0] . " ; " . $g[1] . "\r\n";
			}
			echo $content;
			return;
				
		}
	}
	
	
	/**
	 * Generate a bill when the proect mode is activated
	 */
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
		$modelProject = new CoreProject();
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
	
	/**
	 * Form to generate statistics in the GRR style
	 */
	public function report(){
		
		$navBar = $this->navBar();
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
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
						'searchDate_end' => $searchDate_end
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
			
			$reportModel = new SyReport();
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
						'table' => $table
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
						'summaryTable' => $summaryTable
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
						'summaryTable' => $summaryTable
				) );
				return;
			}
			else if ($outputType == 4){ // details csv
				$this->exportDetailsCSV($table, $lang);
				return;	
			}
			else if ($outputType == 5){ // summary csv
				$summaryTable = $reportModel->summaryseReportStats($table, $entrySummary);
				$this->exportSummaryCSV($summaryTable, $lang);
				return;
			}
		}
		
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Internal method for GRR stats
	 * @param array $table
	 * @param string $lang
	 */
	private function exportDetailsCSV($table, $lang){
		
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=rapport.csv");
		
		$content = "";
		$content.=	SyTranslator::Area($lang)  . " ; "
				.	SyTranslator::Resource($lang)  . " ; "
				.	SyTranslator::Short_description($lang)  . " ; "
				.	SyTranslator::Date($lang) . " ; "
				.	SyTranslator::Full_description($lang). " ; "
				.	SyTranslator::Color_code($lang)  . " ; "
				.	SyTranslator::recipient($lang)  . " \r\n";
		

	   foreach ($table as $t){
	   		$content.=  $t["area_name"] . "; ";
	   		$content.=  $t["resource"] . "; ";
	   		$content.=  $t["short_description"] . "; ";
	   		    
		    $date = date( "d/m/Y à H:i", $t["start_time"]) . " - ";
		    $date .= date( "d/m/Y à H:i", $t["end_time"]);
		           
		    $content.=  $date . ";"; 
		    $content.=  $t["full_description"] . "; ";
		    $content.=  $t["color"] . "; ";
		    $content.=  $t["login"] . " ";
		    $content.= "\r\n";
	   }
	   echo $content;
	}
	
	/**
	 * Internal method for GRR stats
	 * @param array $table
	 * @param string $lang
	 */
	private function exportSummaryCSV($summaryTable, $lang){
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
	
	public function statbookingusers(){
		
		$lang = $this->getLanguage();
		
		// build the form
		$form = new Form($this->request, "sygrrifstats/statbookingusers");
		$form->setTitle(SyTranslator::Statistics_booking_users($lang));
		$form->addDate('startdate', SyTranslator::Date_Start($lang), true, $this->request->getParameterNoException("startdate"));
		$form->addDate('enddate', SyTranslator::Date_End($lang), true, $this->request->getParameterNoException("enddate"));
		$form->setValidationButton(CoreTranslator::Ok($lang), "sygrrifstats/statbookingusers");
		$form->setCancelButton(CoreTranslator::Cancel($lang), "sygrrif");
		
		if ($form->check()){
			// run the database query
			$model = new SyStatsUser();
			$users = $model->bookingUsers(
                                CoreTranslator::dateToEn($form->getParameter("startdate"), $lang), 
                                CoreTranslator::dateToEn($form->getParameter("enddate"), $lang));
			
			$this->exportstatbookingusersCSV($users);
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}
	
	/**
	 * Internal method to export booking users into csv
	 * @param array $table
	 * @param string $lang
	 */
	private function exportstatbookingusersCSV($users){
	
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=bookingusers.csv");
	
		$content = "name ; email \r\n";
	
		foreach ($users as $user){
			$content.=  $user["name"] . ";";
			$content.=  $user["email"] . "\r\n";
			
		}
		echo $content;
	}
}