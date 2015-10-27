<?php


require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpStats.php';

class ControllerSprojectsstats extends ControllerSecureNav {

	public function index() {
		
		
		$searchDate_min = $this->request->getParameterNoException("searchDate_min");
		$searchDate_max = $this->request->getParameterNoException("searchDate_max");
		
		$stats = "";
		if ($searchDate_min != "" && $searchDate_max != ""){
			$modelStats = new SpStats();
			$stats = $modelStats->computeStats($searchDate_min, $searchDate_max);
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'searchDate_min' => $searchDate_min, 'searchDate_max' => $searchDate_max, 'stats' => $stats
		) );
	}
}