<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Project.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyReport.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/projet/Model/recherche.php';
require_once 'Modules/projet/Model/ProjetTranslator.php';

class ControllerRecherche extends ControllerBooking {

	public function __construct() {
	}

	public function index(){
	
		$date = date('Y-m-d');
		$navBar = $this->navBar();
		
		$this->generateView( array (
				'navBar' => $navBar,
				'date'=> $date,
		
		));
	}
	// Affiche la liste de tous les billets du blog
	
	
	public function search(){
		
		$navBar = $this->navBar();
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		/*
		$typeactivite=$this->request->getParameter('typeactivite');
		$nac=$this->request->getParameter('nac');
		$model= new recherche();
		$info= $model->getinfo($typeactivite);
		$donnee =$model->getdonnee($nac);
		$navBar = $this->navBar();
		$this->generateView( array (
				'navBar' => $navBar,
				'info'=>$info,
				'donnee'=>$donnee
		
		));*/
		$ModulesManagerModel = new ModulesManager();
		$isneurinfo= $ModulesManagerModel->isDataMenu("projetcalendar");
		if(isset($isneurinfo)){
		$isrequest = $this->request->getParameterNoException('is_request');
		if ($isrequest == "y"){
		
			
			
			
			$champ = $this->request->getParameterNoException('champ');
			$type_recherche = $this->request->getParameterNoException('type_recherche');
			$text = $this->request->getParameterNoException('text');
			$contition_et_ou = $this->request->getParameterNoException('condition_et_ou');
			$entrySummary = $this->request->getParameterNoException('summary_rq');
			
			//print_r($champ);
			//print_r($type_recherche);
			//print_r($text);
			
			$reportModel = new recherche();
			$table = $reportModel->reportstats( $champ, $type_recherche, $text, $contition_et_ou);
			
			//print_r($table);
			
			$outputType = $this->request->getParameterNoException('output');
			
			if ($outputType == 1){ // only details
				$this->generateView ( array (
						'navBar' => $navBar,
						
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
		$content.=	ProjetTranslator::numerofiche($lang)  . " ; "
				.	ProjetTranslator::type($lang)  . " ; "
				.	"Neuro, Abdo, Cardio"  . " ; "
				.	ProjetTranslator::Acronyme($lang) . " ; "
				.	ProjetTranslator::typeactivite($lang). " ; "
				.	"Prenom investigateur principal". " ; "
				.	"Organisme Partenaire Gestionnaire "  . " ; "
				.	" Correspondant technique Neunrinfo"  . " ; "
				.	"Shanoire"  . " ; "
				.	"Prix"  . " \r\n";
				
		

	   foreach ($table as $t){
	   		$content.=  $t["numerofiche"] . "; ";
	   		$content.=  $t["type"] . "; ";
	   		$content.=  $t["nac"] . "; ";
	   		$content.=  $t["acronyme"] . "; ";
		    $content.=  $t["typeactivite"] . "; ";
		    $content.=  $t["ipprenom"] . "; ";
		    $content.=  $t["opglibelle"] . " ";
		    $content.=  $t["cstnt"] . "; ";
		    $content.=  $t["gamds"] . "; ";
		    $content.=  $t["coutestime"] . " ";
		    $content.= "\r\n";
	   }
	   echo $content;
	}
	
	
	private function exportSummaryCSVNI($summaryTable, $lang){
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=rapport.csv");
	
		$countTable = $summaryTable['countTable'];
		
		$resourcesNames = $summaryTable['acronyme'];
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
		
		foreach ($countTable as $coutT){
			$i++;
			$content .= $entrySummary[$i] . " ; ";
		   	$j = -1;
		   	$totalC = 0;
		   	
		   	foreach ($coutT as $col){
		   		$j++;
		   		$content .= "(" . $col . ")  ; ";
		   		$totalC += $col;
		   		
		   	}
		   	$content .= "(" . $totalC . ")  ";
		   	$content .= "\r\n";
		   	$totalCG += $totalC;
		   	
		}
		
		// total line   
		$content .= "Total ; ";
		for ($i = 0 ; $i < count($resourcesNames) ; $i++){
			// calcualte the sum
		   	$sumC = 0;
		   	
		   	for ($x = 0 ; $x < count($entrySummary) ; $x++){
		   		$sumC += $countTable[$entrySummary[$x]][$resourcesNames[$i]];
		   		
		   	}
		   	$content .= "(" . $sumC . ")  ; "; 
		}
		$content .= "(" . $totalCG .")";
		$content .= " \r\n ";
		echo $content;
	}
}