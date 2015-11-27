<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';
require_once 'Modules/sprojects/Model/SpStats.php';

class ControllerSprojectsstats extends ControllerSecureNav {

	public function index() {
		
		
		$lang = $this->getLanguage();
		
		// build the form
		$myform = new Form($this->request, "formstats");
		$myform->setTitle(SpTranslator::Statistics($lang));
		$myform->addDate("begining_period", SpTranslator::Beginning_period($lang), true, "0000-00-00");
		$myform->addDate("end_period", SpTranslator::End_period($lang), true, "0000-00-00");
		
		$choices = array(SpTranslator::view($lang), SpTranslator::Export_csv($lang) );
		$choicesid = array(0,1);
		$myform->addSelect("exporttype", SpTranslator::ExportType($lang), $choices, $choicesid);
		$myform->setValidationButton("Ok", "sprojectsstats/index");
		
		$stats = "";
		if ($myform->check()){
				
			// run the database query
			$modelStats = new SpStats();
			$stats = $modelStats->computeStats($myform->getParameter("begining_period"),
											   $myform->getParameter("end_period"));
				
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
				'searchDate_min' => $this->request->getParameterNoException("begining_period"),
				'searchDate_max' => $this->request->getParameterNoException("end_period"),
				'stats' => $stats
		) );
	}
	
	protected function exportStats($stats, $searchDate_min, $searchDate_max){
		
		$lang = $this->getLanguage();
		$content = SpTranslator::Bilan_projets($lang) . " " . SpTranslator::period_from($lang) . " "
				. CoreTranslator::dateFromEn($searchDate_min, $lang) . " "
					            . SpTranslator::to($lang) . " " .  CoreTranslator::dateFromEn($searchDate_max, $lang);
		$content .= "\r\n";
				
		$content .= SpTranslator::numberNewIndustryTeam($lang) ." ; ";
		$content .= $stats["numberNewIndustryTeam"] . " (". $stats["purcentageNewIndustryTeam"] . "%)" ;
		$content .= "\r\n";
		$content .= SpTranslator::numberIndustryProjects($lang)." ; ";
		$content .= $stats["numberIndustryProjects"] ;
		$content .= "\r\n";
		$content .= SpTranslator::loyaltyIndustryProjects($lang)." ; ";
		$content .= $stats["loyaltyIndustryProjects"] . " (". $stats["purcentageloyaltyIndustryProjects"] . "%)";
		$content .= "\r\n";
		$content .= "\r\n";
		      		
		$content .= SpTranslator::numberNewAccademicTeam($lang)." ; ";
		$content .= $stats["numberNewAccademicTeam"]  . " (". $stats["purcentageNewAccademicTeam"] . "%)" ;
		$content .= "\r\n";
		$content .= SpTranslator::numberAccademicProjects($lang)." ; ";
		$content .= $stats["numberAccademicProjects"];
		$content .= "\r\n";
		$content .= SpTranslator::loyaltyAccademicProjects($lang)." ; ";
		$content .= $stats["loyaltyAccademicProjects"]  . " (". $stats["purcentageloyaltyAccademicProjects"] . "%)";
		$content .= "\r\n";
		$content .= "\r\n";
		      		
		$content .= SpTranslator::totalNumberOfProjects($lang)." ; ";
		$content .= $stats["totalNumberOfProjects"] ."\r\n";
		
		$fileName = SpTranslator::Statistics($lang) . "_" . SpTranslator::Sprojects($lang);
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=".$fileName.".csv");
		echo $content;

	}
	
	public function responsiblelist(){
		
		$lang = $this->getLanguage();
		
		// build the form
		$myform = new Form($this->request, "formstatslisting");
		$myform->setTitle(SpTranslator::Responsible_list($lang));
		$myform->addDate("begining_period", SpTranslator::Beginning_period($lang), true, "0000-00-00");
		$myform->addDate("end_period", SpTranslator::End_period($lang), true, "0000-00-00");
		$myform->setValidationButton("Ok", "sprojectsstats/responsiblelist");
		
		$stats = "";
		if ($myform->check()){
			// run the database query
			$modelStat = new SpStats();
			$modelStat->getResponsiblesCsv($myform->getParameter("begining_period"), $myform->getParameter("end_period"), $lang);
			return;
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