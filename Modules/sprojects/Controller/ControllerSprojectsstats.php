<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';
require_once 'Modules/sprojects/Model/SpStats.php';

class ControllerSprojectsstats extends ControllerSecureNav {

	public function index() {
		
		
		$searchDate_min = $this->request->getParameterNoException("searchDate_min");
		$searchDate_max = $this->request->getParameterNoException("searchDate_max");
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$stats = "";
		if ($searchDate_min != "" && $searchDate_max != ""){
			$modelStats = new SpStats();
			$stats = $modelStats->computeStats(CoreTranslator::dateToEn($searchDate_min, $lang),
											   CoreTranslator::dateToEn($searchDate_max, $lang));
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'searchDate_min' => $searchDate_min, 'searchDate_max' => $searchDate_max, 'stats' => $stats
		) );
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